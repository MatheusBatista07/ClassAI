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

        $_SESSION['cadastro_etapa1'] = ['email' => $email, 'senha' => $senha];
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

    public function processarEtapa3($nome_usuario, $descricao, $foto)
    {
        if (empty($nome_usuario)) {
            return "O nome de usuário é obrigatório.";
        }

        $foto_url = null;

        if (isset($foto) && $foto['error'] == UPLOAD_ERR_OK) {
            $caminhoUpload = __DIR__ . '/../../public/uploads/perfil/';

            if (!is_dir($caminhoUpload)) {
                mkdir($caminhoUpload, 0777, true);
            }

            $nomeArquivo = uniqid() . '-' . basename($foto['name']);
            $caminhoCompleto = $caminhoUpload . $nomeArquivo;

            if (move_uploaded_file($foto['tmp_name'], $caminhoCompleto)) {
                $foto_url = 'public/uploads/perfil/' . $nomeArquivo;
            } else {
                return "Erro ao salvar a imagem. Verifique as permissões do servidor.";
            }
        }

        $dadosCompletos = array_merge(
            $_SESSION['cadastro_etapa1'],
            $_SESSION['cadastro_etapa2'],
            [
                'nome_usuario' => $nome_usuario,
                'descricao' => $descricao,
                'foto_perfil_url' => $foto_url,
                'termos_aceitos' => true
            ]
        );

        if ($this->usuarioModel->salvarUsuario($dadosCompletos)) {
            session_destroy();
            return null;
        } else {
            return "Ocorreu um erro ao tentar salvar os dados no banco. Tente novamente.";
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
                unset($_SESSION['cadastro_etapa1']);
                unset($_SESSION['cadastro_etapa2']);

                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['usuario_nome'] = $usuario['nome'];
                $_SESSION['usuario_email'] = $usuario['email'];

                return null;
            } else {
                return "Senha incorreta. Por favor, tente novamente.";
            }
        } else {
            return "Nenhum usuário encontrado com este e-mail.";
        }
    }
}
