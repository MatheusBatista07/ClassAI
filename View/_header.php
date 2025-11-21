<?php
// Arquivo: View/_header.php

// Garante que a sessão está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Inclui o UserModel para buscar os dados do usuário
require_once __DIR__ . '/../Model/UserModel.php';

// Busca os dados do usuário logado para usar no header e no popup
$usuario_logado = null;
$id_usuario_logado = $_SESSION['usuario_id'] ?? null;
if ($id_usuario_logado) {
    $userModel = new \Model\UserModel();
    $usuario_logado = $userModel->encontrarUsuarioPorId($id_usuario_logado);
}

// Define a foto de perfil padrão ou a do usuário
$fotoUsuario = '/ClassAI/Images/perfil_padrao.png'; // Padrão
if (isset($usuario_logado['foto_perfil_url']) && !empty($usuario_logado['foto_perfil_url'])) {
    $fotoUsuario = '/ClassAI/' . htmlspecialchars($usuario_logado['foto_perfil_url']);
}
?>

<!-- Div oculta com o ID do usuário para o globalPresence.js -->
<div id="global-user-data" data-user-id="<?php echo htmlspecialchars($id_usuario_logado); ?>"></div>

<!-- CSS dos popups e do header -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="/ClassAI/Templates/css/LazoAI.css">

<!-- HTML do Header -->
<div class="header">
    <div></div> 
    <div class="header-icons">
        <div class="header-icon" id="lazo-popup-button">
            <img src="/ClassAI/Images/Icones-do-header/lazzo.png" alt="Ícone Lazzo" class="lazzo_img">
        </div>
        
        <div class="header-icon"><i class="bi bi-bell"></i></div>
        
        <div class="user-profile" id="user-profile-icon">
            <img src="<?php echo $fotoUsuario; ?>" alt="Avatar do Usuário" class="user-avatar">
            <img src="/ClassAI/Images/Icones-do-header/setinha-perfil.png" alt="Seta" class="arrow-icon">
        </div>
    </div>
</div>

<?php 
// Inclui os popups
require_once __DIR__ . '/_popupPerfil.php'; 
require_once __DIR__ . '/lazo_popup.php'; 
?>

<!-- JavaScript para controlar os popups -->
<script>
document.addEventListener('DOMContentLoaded', function( ) {
    const profileIcon = document.getElementById('user-profile-icon');
    const profilePopup = document.getElementById('profile-popup');

    if (profileIcon && profilePopup) {
        profileIcon.addEventListener('click', function(event) {
            event.stopPropagation();
            profilePopup.classList.toggle('show');
        });

        window.addEventListener('click', function(event) {
            if (profilePopup && !profilePopup.contains(event.target) && !profileIcon.contains(event.target)) {
                profilePopup.classList.remove('show');
            }
        });
    }

    const lazoPopupButton = document.getElementById('lazo-popup-button');
    const lazoPopupOverlay = document.getElementById('lazo-popup-overlay');
    const lazoCloseButton = document.getElementById('lazo-close-button');

    if (lazoPopupButton && lazoPopupOverlay) {
        lazoPopupButton.addEventListener('click', function() {
            lazoPopupOverlay.classList.add('active');
        });

        if (lazoCloseButton) {
            lazoCloseButton.addEventListener('click', function() {
                lazoPopupOverlay.classList.remove('active');
            });
        }

        lazoPopupOverlay.addEventListener('click', function(event) {
            if (event.target === lazoPopupOverlay) {
                lazoPopupOverlay.classList.remove('active');
            }
        });
    }
});
</script>

<!-- Scripts Globais -->
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script src="/ClassAI/Templates/js/LazoAI.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="/ClassAI/Templates/js/globalPresence_v2.js"></script>
