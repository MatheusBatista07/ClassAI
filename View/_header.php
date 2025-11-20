<?php
if (session_status() === PHP_SESSION_NONE) { session_start(); }

$fotoUsuario = '/ClassAI/Images/perfil_padrao.png';
if (isset($_SESSION['usuario_foto_url']) && !empty($_SESSION['usuario_foto_url'])) {
    $fotoUsuario = '/ClassAI/' . htmlspecialchars($_SESSION['usuario_foto_url']);
}
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="/ClassAI/Templates/css/LazoAI.css">

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
require_once __DIR__ . '/_popupPerfil.php'; 
require_once __DIR__ . '/lazo_popup.php'; 
?>

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
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script src="/ClassAI/Templates/js/LazoAI.js"></script>