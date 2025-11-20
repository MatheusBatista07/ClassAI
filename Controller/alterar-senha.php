<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../Model/UserModel.php';

use Model\UserModel;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../View/pagina-configuracoes.php');
    exit;
}

$senha_atual = $_POST['senha_atual'] ?? null;
$nova_senha = $_POST['nova_senha'] ?? null;
$confirmar_nova_senha = $_POST['confirmar_nova_senha'] ?? null;
$userId = $_SESSION['usuario_id'];

if (!$senha_atual || !$nova_senha || !$confirmar_nova_senha) {
    header('Location: ../View/pagina-configuracoes.php?status=error&msg=campos_vazios');
    exit;
}

if ($nova_senha !== $confirmar_nova_senha) {
    header('Location: ../View/pagina-configuracoes.php?status=error&msg=senhas_nao_coincidem');
    exit;
}

if (strlen($nova_senha) < 6) {
    header('Location: ../View/pagina-configuracoes.php?status=error&msg=senha_curta');
    exit;
}

$userModel = new UserModel();
$usuario = $userModel->encontrarUsuarioPorId($userId);

if (!$usuario) {
    header('Location: /ClassAI/logout.php');
    exit;
}

if (password_verify($senha_atual, $usuario['senha'])) {
    $sucesso = $userModel->atualizarSenhaPeloId($userId, $nova_senha);

    if ($sucesso) {
        header('Location: ../View/pagina-configuracoes.php?status=success&msg=senha_alterada');
        exit;
    } else {
        header('Location: ../View/pagina-configuracoes.php?status=error&msg=db_error');
        exit;
    }
} else {
    header('Location: ../View/pagina-configuracoes.php?status=error&msg=senha_atual_incorreta');
    exit;
}
