<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../Model/CursosModel.php';

use Model\CursosModel;

$userId = $_SESSION['usuario_id'] ?? null;
$aulaId = $_GET['aula_id'] ?? null;

if (!$aulaId || !$userId) {
    header('Location: PaginaHome.php');
    exit;
}

$cursosModel = new CursosModel();
$aula = $cursosModel->getAulaById((int)$aulaId);

if (!$aula) {
    die("Aula não encontrada.");
}

$videoId = null;
if (!empty($aula['video_aula'] )) {
    parse_str(parse_url($aula['video_aula'], PHP_URL_QUERY), $vars);
    $videoId = $vars['v'] ?? null;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAI | <?php echo htmlspecialchars($aula['titulo_aula']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/ClassAI/Templates/css/pagina-aula.css">
</head>

<body>
    
    <?php require_once __DIR__ . '/_sidebar.php'; ?>

    <div class="main-content">
        
        <?php require_once __DIR__ . '/_header.php'; // AGORA USANDO O HEADER UNIVERSAL ?>

        <div class="material-area">
            <a href="pagina-modulo.php?mod_id=<?php echo $aula['id_mod_fk']; ?>" class="btn-voltar">
                <i class="bi bi-arrow-left-circle"></i> Voltar para o Módulo
            </a>

            <header class="material-header">
                <h1><?php echo htmlspecialchars($aula['titulo_aula']  ); ?></h1>
            </header>

            <div class="video-container">
                <?php if ($videoId): ?>
                    <iframe 
                        src="https://www.youtube.com/embed/<?php echo $videoId; ?>" 
                        title="YouTube video player" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen>
                    </iframe>
                <?php else: ?>
                    <div class="alert alert-warning">Nenhum vídeo cadastrado para esta aula.</div>
                <?php endif; ?>
            </div>

            <?php if (!empty($aula['material_aula']  )): ?>
                <div class="material-content">
                    <h2>Material de Apoio</h2>
                    <p><?php echo nl2br(htmlspecialchars($aula['material_aula'])); ?></p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- SCRIPTS GLOBAIS REMOVIDOS DAQUI -->

</body>
</html>
