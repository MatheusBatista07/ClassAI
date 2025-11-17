<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../Model/CursosModel.php';
require_once __DIR__ . '/../Model/UserModel.php';

use Model\CursosModel;
use Model\UserModel;

$userId = $_SESSION['usuario_id'] ?? null;
$modId = $_GET['mod_id'] ?? null;

if (!$modId || !$userId) {
    die("Acesso inválido.");
}

$cursosModel = new CursosModel();
$modulo = $cursosModel->getModuloEAulasPorId((int)$modId);

if (!$modulo) {
    die("Módulo não encontrado.");
}

$userModel = new UserModel();
$usuarioLogado = $userModel->encontrarUsuarioPorId($userId);
$fotoUsuario = !empty($usuarioLogado['foto_perfil_url']) ? '/ClassAI/' . htmlspecialchars($usuarioLogado['foto_perfil_url']) : 'https://via.placeholder.com/40';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAI | <?php echo htmlspecialchars($modulo['titulo_mod'] ); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../Templates/css/pagina-modulo.css">
</head>

<body>
    <div class="sidebar">
        <img src="../Images/Icones-do-header/Logo-ClassAI-branca.png" alt="Logo ClassAI" class="img-logo">
        <ul class="nav-menu">
            <li class="nav-item"><a href="PaginaHome.php" class="nav-link"><i class="bi bi-house-door"></i> Principal</a></li>
            <li class="nav-item"><a href="paginaChat.php" class="nav-link"><i class="bi bi-chat"></i> Chat</a></li>
            <li class="nav-item"><a href="PaginaPrincipalCursos.php" class="nav-link active"><i class="bi bi-book"></i> Cursos</a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-award"></i> Certificados</a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-people"></i> Amigos</a></li>
        </ul>
        <div class="nav-divider"></div>
        <ul class="nav-menu">
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-question-circle"></i> Ajuda e FAQ</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Modo escuro <i class="bi bi-moon-stars ms-auto"></i></a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <div></div>
            <div class="header-icons">
                <div class="header-icon"><img src="../Images/Icones-do-header/lazzo.png" alt="Ícone Lazzo" class="lazzo_img"></div>
                <div class="header-icon"><i class="bi bi-bell"></i></div>
                <div class="user-profile">
                    <img src="<?php echo $fotoUsuario; ?>" alt="Avatar do Usuário" class="user-avatar">
                    <img src="../Images/Icones-do-header/setinha-perfil.png" alt="Seta" class="arrow-icon">
                </div>
            </div>
        </div>

        <div class="lesson-area">
            <a href="pagina-curso.php?id=<?php echo $modulo['id_curso_fk']; ?>" class="btn-voltar">
                <i class="bi bi-arrow-left-circle"></i> Voltar para Módulos
            </a>

            <header class="lesson-header">
                <h1><?php echo htmlspecialchars($modulo['titulo_mod'] ); ?></h1>
            </header>

            <div class="lesson-content-grid">
                <div class="video-section">
                    <h2>Vídeo Aulas</h2>
                    <div id="video-list" class="video-grid">
                        <?php if (empty($modulo['aulas'])): ?>
                            <p class="text-white-50">Nenhuma vídeo aula encontrada para este módulo.</p>
                        <?php else: ?>
                            <?php foreach ($modulo['aulas'] as $aula): ?>
                                <a href="pagina-aula.php?aula_id=<?php echo $aula['id_aula']; ?>" class="video-card">
                                    <div class="video-thumbnail">
                                        <i class="bi bi-play-fill"></i>
                                    </div>
                                    <span class="video-title"><?php echo htmlspecialchars($aula['titulo_aula']); ?></span>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="materials-section">
                    <h2>Material de Estudo</h2>
                    <div id="materials-list" class="materials-list">
                        <?php if (empty($modulo['aulas'])): ?>
                            <p class="text-white-50">Nenhum material encontrado para este módulo.</p>
                        <?php else: ?>
                            <?php foreach ($modulo['aulas'] as $aula): ?>
                                <a href="pagina-material.php?aula_id=<?php echo $aula['id_aula']; ?>" class="material-item">
                                    <i class="bi bi-file-earmark-arrow-down"></i>
                                    <span>Material da: <?php echo htmlspecialchars($aula['titulo_aula']); ?></span>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
