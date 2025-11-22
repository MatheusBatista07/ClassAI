<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Se o usuário não está logado ou não tem a função 'admin', redireciona para a home.
if (!isset($_SESSION['usuario_id']) || !isset($_SESSION['usuario_funcao']) || $_SESSION['usuario_funcao'] !== 'admin') {
    header('Location: /ClassAI/View/PaginaHome.php');
    exit;
}
?>
