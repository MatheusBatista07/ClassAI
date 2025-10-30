<?php

namespace Controller;

use Model\UserModel;

require_once __DIR__ . '/../Model/UserModel.php';

class UserController
{
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UserModel();
    }

    public function processarEtapa1($email, $senha, $confirmaSenha, $termos)
    {
        if (empty($email) || empty($senha)) {
            return "E-mail e senha são obrigatórios.";
        }
        if ($senha !== $confirmaSenha) {
            return "As senhas não conferem.";
        }
        if (!$termos) {
            return "Você precisa aceitar os Termos de Uso e a Política de Privacidade.";
        }
        if ($this->usuarioModel->emailJaExiste($email)) {
            return "Este e-mail já está em uso.";
        }

        $_SESSION['cadastro_etapa1'] = ['email' => $email, 'senha' => $senha, 'termos_aceitos' => $termos];
        return null;
    }

    public function processarEtapa2($nome, $sobrenome, $formacao, $cpf)
    {
        if (empty($nome) || empty($sobrenome) || empty($formacao) || empty($cpf)) {
            return "Todos os campos são obrigatórios.";
        }

        $cpfLimpo = preg_replace('/[^0-9]/', '', $cpf);
        if (strlen($cpfLimpo) != 11) {
            return "O CPF digitado é inválido.";
        }

        if ($this->usuarioModel->cpfJaExiste($cpfLimpo)) {
            return "Este CPF já está cadastrado.";
        }

        $_SESSION['cadastro_etapa2'] = ['nome' => $nome, 'sobrenome' => $sobrenome, 'formacao' => $formacao, 'cpf' => $cpfLimpo];
        return null;
    }

    public function processarEtapa3(array $postData, array $fileData)
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $nome_usuario = $postData['username'] ?? '';
        $descricao = $postData['description'] ?? '';
        $caminhoFoto = null;

        if (isset($fileData['profile_photo']) && $fileData['profile_photo']['error'] === UPLOAD_ERR_OK) {
            $foto = $fileData['profile_photo'];
            $caminhoTemporario = $foto['tmp_name'];
            $pastaDestino = __DIR__ . '/../public/uploads/perfil/';
            
            if (!is_dir($pastaDestino)) {
                mkdir($pastaDestino, 0775, true);
            }

            $extensao = pathinfo($foto['name'], PATHINFO_EXTENSION);
            $nomeUnico = uniqid('user_') . bin2hex(random_bytes(8)) . '.' . $extensao;
            $caminhoCompletoDestino = $pastaDestino . $nomeUnico;

            if (move_uploaded_file($caminhoTemporario, $caminhoCompletoDestino)) {
                $caminhoFoto = 'public/uploads/perfil/' . $nomeUnico;
            }
        }

        $dadosUsuario = array_merge(
            $_SESSION['cadastro_etapa1'] ?? [],
            $_SESSION['cadastro_etapa2'] ?? [],
            [
                'nome_usuario' => $nome_usuario,
                'descricao' => $descricao,
                'foto_perfil_url' => $caminhoFoto
            ]
        );

        if ($this->usuarioModel->salvarUsuario($dadosUsuario)) {
            session_unset();
            session_destroy();
            header('Location: ../View/pagina-login.php?status=cadastro_sucesso');
            exit;
        } else {
            return "Ocorreu um erro ao finalizar o cadastro. Tente novamente.";
        }
    }

    public function processarLogin($email, $senha)
    {
        if (empty($email) || empty($senha)) {
            return "E-mail e senha são obrigatórios.";
        }

        $usuario = $this->usuarioModel->encontrarUsuarioPorEmail($email);

        if ($usuario) {
            if (password_verify($senha, $usuario['senha'])) {
                if (session_status() == PHP_SESSION_NONE) {
                    session_start();
                }
                session_regenerate_id(true);

                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                
                $this->usuarioModel->atualizarStatus($usuario['id'], 'online');
                
                header('Location: ../View/paginaChat.php');
                exit;
            } else {
                return "Senha incorreta. Por favor, tente novamente.";
            }
        } else {
            return "Nenhum usuário encontrado com este e-mail.";
        }
    }

    public function processarDelecao(int $userId): bool
    {
        $caminhoFoto = $this->usuarioModel->deletarUsuario($userId);

        if ($caminhoFoto === false) {
            return false;
        }

        if (!empty($caminhoFoto)) {
            $caminhoCompletoArquivo = __DIR__ . '/../' . $caminhoFoto;
            if (file_exists($caminhoCompletoArquivo)) {
                @unlink($caminhoCompletoArquivo);
            }
        }
        
        return true;
    }
}
