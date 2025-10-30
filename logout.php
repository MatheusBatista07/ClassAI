<?php

require_once __DIR__ . '/Model/UserModel.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['usuario_id'])) {
    $userModel = new \Model\UserModel();
    $userModel->atualizarStatus($_SESSION['usuario_id'], 'offline');
}

session_unset();
session_destroy();

header('Location: /ClassAI/View/pagina-login.php?status=logout_sucesso');
exit;
?>
