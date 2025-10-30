<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/Model/UserModel.php';

function logoutAndRedirect() {
    session_unset();
    session_destroy();
    header('Location: /ClassAI/View/pagina-login.php?erro=sessao_invalida');
    exit;
}

if (!isset($_SESSION['usuario_id'])) {
    logoutAndRedirect();
}

$userId = $_SESSION['usuario_id'];
if (!is_numeric($userId) || $userId <= 0) {
    logoutAndRedirect();
}

try {
    $userModel = new \Model\UserModel();
    $usuario = $userModel->encontrarUsuarioPorId((int)$userId);

    if (!$usuario) {
        logoutAndRedirect();
    }
} catch (Throwable $e) {
    logoutAndRedirect();
}
?>
