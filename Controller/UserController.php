<?php

namespace Controller;

use Model\UserModel;

require_once __DIR__ . '/../Model/UserModel.php';

class UserController
{
    private $usuarioModel;

    // IVY: FIZ A ALTERAÇÃO NECESSÁRIA PARA RODAR O TESTE PHP UNIT
    public function __construct(UserModel $usuarioModel)
    {
        $this->usuarioModel = $usuarioModel;
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
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
        if ($this->usuarioModel->cpfJaExiste($cpf)) {
            return "Este CPF já está cadastrado.";
        }

        $_SESSION['cadastro_etapa2'] = ['nome' => $nome, 'sobrenome' => $sobrenome, 'formacao' => $formacao, 'cpf' => $cpf];
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
                // Apenas cria o diretório se ele não existir
                mkdir($caminhoUpload, 0777, true);
            }

            $nomeArquivo = uniqid() . '-' . basename($foto['name']);
            $caminhoCompleto = $caminhoUpload . $nomeArquivo;

            if (move_uploaded_file($foto['tmp_name'], $caminhoCompleto)) {
                $foto_url = 'public/uploads/perfil/' . $nomeArquivo;
            } else {
                // Adiciona um retorno de erro caso o upload falhe por permissão, etc.
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

        // AGORA ESTA PARTE SERÁ EXECUTADA
        if ($this->usuarioModel->salvarUsuario($dadosCompletos)) {
            session_destroy();
            return null; // Retorna null para indicar sucesso
        } else {
            return "Ocorreu um erro ao tentar salvar os dados no banco. Tente novamente.";
        }
    }
}
