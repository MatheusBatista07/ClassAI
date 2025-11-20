<?php

require_once __DIR__ . '/../Model/Connection.php';
require_once __DIR__ . '/../Model/UserModel.php';

use Model\UserModel;

// ==================================================
// LINHA CRUCIAL ADICIONADA: CONFIGURA O FUSO HORÁRIO
date_default_timezone_set('America/Sao_Paulo');
// ==================================================

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../View/pagina-login.php');
    exit;
}

$token = $_POST['token'] ?? null;
$nova_senha = $_POST['nova_senha'] ?? null;
$confirmar_senha = $_POST['confirmar_senha'] ?? null;

if (!$token || !$nova_senha || !$confirmar_senha) {
    header('Location: ../View/redefinir-senha.php?token=' . urlencode($token) . '&error=campos_vazios');
    exit;
}

if ($nova_senha !== $confirmar_senha) {
    header('Location: ../View/redefinir-senha.php?token=' . urlencode($token) . '&error=senhas_diferentes');
    exit;
}

try {
    $pdo = Model\Connection::getInstance();

    $sql = "SELECT email, created_at FROM password_resets WHERE token = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$token]);
    $reset_request = $stmt->fetch();

    if (!$reset_request) {
        header('Location: ../View/redefinir-senha.php?token=' . urlencode($token) . '&error=token_invalido');
        exit;
    }

    $token_created_at = new DateTime($reset_request['created_at']);
    $now = new DateTime();
    $diff = $now->getTimestamp() - $token_created_at->getTimestamp();

    if ($diff > 3600) { // 3600 segundos = 1 hora
        header('Location: ../View/redefinir-senha.php?token=' . urlencode($token) . '&error=token_invalido');
        exit;
    }

    $email = $reset_request['email'];
    $userModel = new UserModel();
    $sucesso = $userModel->atualizarSenha($email, $nova_senha);

    if ($sucesso) {
        $sql_delete = "DELETE FROM password_resets WHERE email = ?";
        $stmt_delete = $pdo->prepare($sql_delete);
        $stmt_delete->execute([$email]);

        header('Location: ../View/pagina-login.php?status=senha_redefinida');
        exit;
    } else {
        header('Location: ../View/redefinir-senha.php?token=' . urlencode($token) . '&error=db_error');
        exit;
    }

} catch (Exception $e) {
    error_log('Erro ao processar redefinição de senha: ' . $e->getMessage());
    header('Location: ../View/redefinir-senha.php?token=' . urlencode($token) . '&error=db_error');
    exit;
}
