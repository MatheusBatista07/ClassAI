<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id']) && isset($_COOKIE['remember_me'])) {
    list($cookie_userId, $cookie_token) = explode(':', $_COOKIE['remember_me'], 2);

    if ($cookie_userId && $cookie_token) {
        require_once __DIR__ . '/Model/UserModel.php';
        $userModelForCookie = new \Model\UserModel();
        
        $usuarioFromCookie = $userModelForCookie->encontrarUsuarioPorId((int)$cookie_userId);

        if ($usuarioFromCookie && isset($usuarioFromCookie['remember_token_hash']) && isset($usuarioFromCookie['remember_token_expires_at'])) {
            $token_hash = hash('sha256', $cookie_token);
            $expected_hash = $usuarioFromCookie['remember_token_hash'];

            if (hash_equals($expected_hash, $token_hash) && (new DateTime() < new DateTime($usuarioFromCookie['remember_token_expires_at']))) {
                
                session_regenerate_id(true);
                $_SESSION['usuario_id'] = $usuarioFromCookie['id'];
                $_SESSION['usuario_nome'] = $usuarioFromCookie['nome'];
                $_SESSION['usuario_sobrenome'] = $usuarioFromCookie['sobrenome'];
                $_SESSION['usuario_foto_url'] = $usuarioFromCookie['foto_perfil_url'];
                $_SESSION['usuario_funcao'] = $usuarioFromCookie['funcao'];

                $userModelForCookie->atualizarStatus($usuarioFromCookie['id'], 'online');
            } else {
                setcookie('remember_me', '', time() - 3600, "/");
            }
        } else {
            setcookie('remember_me', '', time() - 3600, "/");
        }
    }
}

require_once __DIR__ . '/Model/UserModel.php';

function logoutAndRedirect() {
    if (isset($_COOKIE['remember_me'])) {
        setcookie('remember_me', '', time() - 3600, "/");
    }
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
