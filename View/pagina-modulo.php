<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../Model/CursosModel.php';

use Model\CursosModel;

$userId = $_SESSION['usuario_id'] ?? null;
$modId = $_GET['mod_id'] ?? null;

if (!$modId || !$userId) {
    header('Location: PaginaHome.php');
    exit;
}

$cursosModel = new CursosModel();
$modulo = $cursosModel->getModuloEAulasPorId((int)$modId);

if (!$modulo) {
    die("Módulo não encontrado.");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAI | <?php echo htmlspecialchars($modulo['titulo_mod'] ); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/ClassAI/Templates/css/pagina-modulo.css">
</head>

<body>

    <?php require_once __DIR__ . '/_sidebar.php'; // AGORA USANDO A SIDEBAR UNIVERSAL ?>

    <div class="main-content">
        
        <?php require_once __DIR__ . '/_header.php'; // AGORA USANDO O HEADER UNIVERSAL ?>

        <div class="lesson-area">
            <a href="pagina-curso.php?id=<?php echo $modulo['id_curso_fk']; ?>" class="btn-voltar">
                <i class="bi bi-arrow-left-circle"></i> Voltar para o Curso
            </a>

            <header class="lesson-header">
                <h1><?php echo htmlspecialchars($modulo['titulo_mod']  ); ?></h1>
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

    <!-- SCRIPTS GLOBAIS REMOVIDOS DAQUI -->

</body>
</html>
