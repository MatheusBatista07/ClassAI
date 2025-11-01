<?php

require_once __DIR__ . '/vendor/autoload.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['usuario_id'])) {
    try {
        $userModel = new \Model\UserModel();
        $userModel->atualizarStatus($_SESSION['usuario_id'], 'offline');
    } catch (\Exception $e) {
        error_log('Erro ao atualizar status no logout: ' . $e->getMessage());
    }
}

$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
     );
}

session_destroy();

header('Location: /ClassAI/View/pagina-login.php?status=logout_sucesso');
exit;
