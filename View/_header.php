<?php
// Arquivo: View/_header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Inclui o arquivo de configuração para ter acesso às constantes do Pusher
require_once __DIR__ . '/../Config/Configuration.php';
require_once __DIR__ . '/../Model/UserModel.php';

$usuario_logado = null;
$id_usuario_logado = $_SESSION['usuario_id'] ?? null;
if ($id_usuario_logado) {
    $userModel = new \Model\UserModel();
    $usuario_logado = $userModel->encontrarUsuarioPorId($id_usuario_logado);
}

$fotoUsuario = '/ClassAI/Images/perfil_padrao.png';
if (isset($usuario_logado['foto_perfil_url']) && !empty($usuario_logado['foto_perfil_url'])) {
    $fotoUsuario = '/ClassAI/' . htmlspecialchars($usuario_logado['foto_perfil_url']);
}
?>

<!-- Div oculta com dados do usuário para o JS -->
<div id="global-user-data" data-user-id="<?php echo htmlspecialchars($id_usuario_logado); ?>"
    data-pusher-key="<?php echo PUSHER_APP_KEY; ?>" data-pusher-cluster="<?php echo PUSHER_APP_CLUSTER; ?>">
</div>

<!-- CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="/ClassAI/Templates/css/LazoAI.css">
<link rel="stylesheet" href="/ClassAI/Templates/css/notifications.css">

<?php
// =====================================================================
// ALTERAÇÃO APLICADA AQUI
// Carrega o CSS específico do chat apenas quando estiver na página de chat.
// =====================================================================
if (basename($_SERVER['PHP_SELF'] ) == 'paginaChat.php') {
    echo '<link rel="stylesheet" href="/ClassAI/Templates/css/paginaChat.css">';
}
?>

<!-- HTML do Header -->
<div class="header">
    <div></div>
    <div class="header-icons">
        <div class="header-icon" id="lazo-popup-button">
            <img src="/ClassAI/Images/Icones-do-header/lazzo.png" alt="Ícone Lazzo" class="lazzo_img">
        </div>

        <!-- Container do sino de notificação -->
        <div class="notification-container">
            <div class="header-icon notification-bell" id="notificationBell">
                <i class="bi bi-bell"></i>
                <span class="notification-badge" id="notificationBadge" style="display: none;"></span>
            </div>
            <?php require_once __DIR__ . '/_popupNotificacao.php'; ?>
        </div>

        <div class="user-profile" id="user-profile-icon">
            <img src="<?php echo $fotoUsuario; ?>" alt="Avatar do Usuário" class="user-avatar">
            <img src="/ClassAI/Images/Icones-do-header/setinha-perfil.png" alt="Seta" class="arrow-icon">
        </div>
    </div>
</div>

<?php
// Inclui os outros popups
require_once __DIR__ . '/_popupPerfil.php';
require_once __DIR__ . '/lazo_popup.php';
?>

<!-- Scripts Globais -->
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script src="/ClassAI/Templates/js/LazoAI.js"></script>
<script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
<script src="/ClassAI/Templates/js/globalPresence_v2.js"></script>
<script src="/ClassAI/Templates/js/header_popups.js"></script>
<script src="/ClassAI/Templates/js/notification_handler.js"></script>
