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

// Em Controller/UserController.php

// ... (dentro da classe UserController)

// Este é um exemplo de como o método de processar a etapa 3 deveria ser.
// Adapte ao nome do seu método.
public function processarEtapa3(array $postData, array $fileData) {
    
    // Inicia a sessão para pegar os dados das etapas anteriores
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Validação dos dados do formulário (nome de usuário, etc.)
    $nome_usuario = $postData['username'] ?? '';
    $descricao = $postData['description'] ?? '';
    // Adicione outras validações se necessário...

    // --- LÓGICA DE UPLOAD DA IMAGEM (A PARTE QUE FALTAVA) ---
    $caminhoFoto = null; // Começa como nulo

    // Verifica se um arquivo foi enviado e se não houve erro no upload
    if (isset($fileData['profile_photo']) && $fileData['profile_photo']['error'] === UPLOAD_ERR_OK) {
        
        $foto = $fileData['profile_photo'];
        $nomeOriginal = $foto['name'];
        $caminhoTemporario = $foto['tmp_name'];

        // Define a pasta de destino
        $pastaDestino = __DIR__ . '/../public/uploads/perfil/';
        
        // Garante que a pasta de destino exista
        if (!is_dir($pastaDestino)) {
            mkdir($pastaDestino, 0777, true);
        }

        // Cria um nome de arquivo único para evitar sobreposição
        $extensao = pathinfo($nomeOriginal, PATHINFO_EXTENSION);
        $nomeUnico = uniqid() . '-' . bin2hex(random_bytes(8)) . '.' . $extensao;
        
        // Define o caminho completo do destino
        $caminhoCompletoDestino = $pastaDestino . $nomeUnico;

        // **A FUNÇÃO MÁGICA: Move o arquivo do local temporário para o destino permanente**
        if (move_uploaded_file($caminhoTemporario, $caminhoCompletoDestino)) {
            // SUCESSO! Agora, salvamos o caminho relativo no banco.
            $caminhoFoto = 'public/uploads/perfil/' . $nomeUnico;
        } else {
            // Falha ao mover o arquivo, pode ser um problema de permissão na pasta.
            // Por enquanto, apenas ignoramos a foto.
            $caminhoFoto = null;
        }
    }
    // --- FIM DA LÓGICA DE UPLOAD ---

    // Junta todos os dados para salvar no banco
    $dadosUsuario = array_merge(
        $_SESSION['cadastro_etapa1'] ?? [],
        $_SESSION['cadastro_etapa2'] ?? [],
        [
            'nome_usuario' => $nome_usuario,
            'descricao' => $descricao,
            'foto_perfil_url' => $caminhoFoto // Usa o caminho da foto que foi salva
        ]
    );

    $userModel = new \Model\UserModel();
    if ($userModel->salvarUsuario($dadosUsuario)) {
        // Limpa a sessão e redireciona para o login
        session_destroy();
        header('Location: ../View/pagina-login.php?sucesso=cadastro');
        exit;
    } else {
        // Retorna uma mensagem de erro
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
