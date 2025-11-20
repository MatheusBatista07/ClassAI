<?php
// Este bloco busca as informações do usuário logado.
// Ele precisa ser incluído em todas as páginas que usam o header.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../Model/UserModel.php';

$userId = $_SESSION['usuario_id'] ?? null;
$fotoUsuario = 'https://via.placeholder.com/40'; // Valor padrão

if ($userId ) {
    $userModel = new \Model\UserModel();
    $usuarioLogado = $userModel->encontrarUsuarioPorId($userId);
    if (!empty($usuarioLogado['foto_perfil_url'])) {
        $fotoUsuario = '/ClassAI/' . htmlspecialchars($usuarioLogado['foto_perfil_url']);
    }
}
?>

<!-- HTML do Cabeçalho -->
<div class="header">
    <div></div>
    <div class="header-icons">
        <div class="header-icon"><img src="../Images/Icones-do-header/lazzo.png" alt="Ícone Lazzo" class="lazzo_img"></div>
        <div class="header-icon"><i class="bi bi-bell"></i></div>
        
        <!-- Elemento que aciona o popup -->
        <div class="user-profile" id="user-profile-icon">
            <img src="<?php echo $fotoUsuario; ?>" alt="Avatar do Usuário" class="user-avatar">
            <img src="../Images/Icones-do-header/setinha-perfil.png" alt="Seta" class="arrow-icon">
        </div>
    </div>
</div>

<?php
// Inclui o HTML e o CSS do popup que criamos
require_once __DIR__ . '/_popupPerfil.php';
?>

<!-- JavaScript para controlar o Popup -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const profileIcon = document.getElementById('user-profile-icon');
    const profilePopup = document.getElementById('profile-popup');

    if (profileIcon && profilePopup) {
        profileIcon.addEventListener('click', function(event) {
            // Impede que o clique se propague para outros elementos
            event.stopPropagation();
            // Alterna a classe 'show' para mostrar ou esconder o popup
            profilePopup.classList.toggle('show');
        });

        // Fecha o popup se o usuário clicar em qualquer outro lugar da tela
        window.addEventListener('click', function(event) {
            if (!profilePopup.contains(event.target) && !profileIcon.contains(event.target)) {
                profilePopup.classList.remove('show');
            }
        });
    }
});
</script>
