<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../Model/UserModel.php';
require_once __DIR__ . '/../Model/AmigosModel.php';

$userModel = new \Model\UserModel();
$amigosModel = new \Model\AmigosModel();

$meuId = $_SESSION['usuario_id'];
$perfilId = $_GET['id'] ?? $meuId;
$isMeuPerfil = ($perfilId == $meuId);

$usuario = $userModel->encontrarUsuarioPorId($perfilId);

if (!$usuario) {
    header('Location: PaginaHome.php');
    exit;
}

$contagens = $amigosModel->getFollowCounts($perfilId);
$numSeguindo = $contagens['following'];
$numSeguidores = $contagens['followers'];

$euSigoEstePerfil = false;
if (!$isMeuPerfil) {
    $euSigoEstePerfil = $amigosModel->isFollowing($meuId, $perfilId);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($usuario['nome']); ?> - ClassAI</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/ClassAI/Templates/css/pagina-perfil.css">
</head>
<body>

    <?php require_once __DIR__ . '/_sidebar.php'; ?>

    <div class="main-content">
    
        <?php require_once __DIR__ . '/_header.php'; ?>

        <main class="container-perfil">
            <div class="perfil-header-container">
                <h1 class="perfil-main-title"><?php echo $isMeuPerfil ? 'Meu Perfil' : 'Perfil de ' . htmlspecialchars($usuario['nome']  ); ?></h1>
                <?php if (!$isMeuPerfil): ?>
                    <a href="javascript:history.back()" id="btn-voltar-perfil" class="btn-voltar">
                        <i class="bi bi-arrow-left"></i> Voltar
                    </a>
                <?php endif; ?>
            </div>
            
            <div id="form-feedback" class="alert" style="display: none;"></div>

            <form id="form-editar-perfil" class="perfil-card" data-perfil-id="<?php echo $perfilId; ?>">
                <div class="perfil-body">
                    <div class="info-grupo">
                        <label>Foto de Perfil</label>
                        <div class="foto-container" data-contact-id="<?php echo $perfilId; ?>">
                            <img src="<?php echo '/ClassAI/' . htmlspecialchars($usuario['foto_perfil_url'] ?? 'Images/perfil_padrao.png'); ?>" alt="Foto de Perfil" class="foto-perfil">
                            <?php if (!$isMeuPerfil): ?>
                                <div id="status-indicator-<?php echo $perfilId; ?>" class="status-indicator-profile"></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="info-grupo">
                        <label>Nome Completo</label>
                        <span class="view-mode"><?php echo htmlspecialchars($usuario['nome'] . ' ' . $usuario['sobrenome']); ?></span>
                        <?php if ($isMeuPerfil): ?>
                            <div class="edit-mode" style="display: none;">
                                <input type="text" id="nome" name="nome" class="form-control-perfil" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
                                <input type="text" id="sobrenome" name="sobrenome" class="form-control-perfil mt-2" value="<?php echo htmlspecialchars($usuario['sobrenome']); ?>" required>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="perfil-stats">
                        <div id="following-link" class="stat-item" data-type="following">
                            <strong><?php echo $numSeguindo; ?></strong><span>Seguindo</span>
                        </div>
                        <div id="followers-link" class="stat-item" data-type="followers">
                            <strong id="follower-count"><?php echo $numSeguidores; ?></strong><span>Seguidores</span>
                        </div>
                    </div>

                    <div class="info-grupo">
                        <label>Email</label>
                        <span><?php echo htmlspecialchars($usuario['email']); ?></span>
                    </div>

                    <div class="info-grupo">
                        <label>Função</label>
                        <span class="funcao-tag"><?php echo htmlspecialchars(ucfirst($usuario['funcao'])); ?></span>
                    </div>

                    <div class="perfil-actions">
                        <?php if ($isMeuPerfil): ?>
                            <button type="button" id="btn-editar" class="btn-editar view-mode">Editar Perfil</button>
                            <button type="submit" id="btn-salvar" class="btn-editar edit-mode" style="display: none;">Salvar Alterações</button>
                            <button type="button" id="btn-cancelar" class="btn-cancelar edit-mode" style="display: none;">Cancelar</button>
                        <?php else: ?>
                            <button type="button" id="follow-button" 
                                    class="btn-amigos <?php echo $euSigoEstePerfil ? 'btn-unfollow' : 'btn-follow'; ?>" 
                                    data-profile-id="<?php echo $perfilId; ?>">
                                <?php echo $euSigoEstePerfil ? 'Deixar de Seguir' : 'Seguir'; ?>
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </form>
        </main>
    </div>

    <script src="/ClassAI/Templates/js/perfil-dinamico.js"></script>

    <div id="follow-modal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modal-title"></h3>
                <button id="modal-close-btn" class="modal-close">&times;</button>
            </div>
            <div id="modal-body" class="modal-body">
            </div>
        </div>
    </div>

</body>
</html>
