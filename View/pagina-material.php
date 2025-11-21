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
    die("Material não encontrado.");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material: <?php echo htmlspecialchars($aula['titulo_aula'] ); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/ClassAI/Templates/css/pagina-material.css">
</head>

<body>

    <?php require_once __DIR__ . '/_sidebar.php'; // AGORA USANDO A SIDEBAR UNIVERSAL ?>

    <div class="main-content">
        
        <?php require_once __DIR__ . '/_header.php'; // AGORA USANDO O HEADER UNIVERSAL ?>

        <div class="material-area">
            <a href="pagina-modulo.php?mod_id=<?php echo $aula['id_mod_fk']; ?>" class="btn-voltar">
                <i class="bi bi-arrow-left-circle"></i> Voltar para o Módulo
            </a>

            <header class="material-header">
                <h1>Material de Apoio: <?php echo htmlspecialchars($aula['titulo_aula']  ); ?></h1>
            </header>

            <div class="material-content">
                <?php if (!empty($aula['material_aula'])): ?>
                    <p><?php echo nl2br(htmlspecialchars($aula['material_aula'])); ?></p>
                <?php else: ?>
                    <div class="alert alert-secondary">Nenhum material de apoio cadastrado para esta aula.</div>
                <?php endif; ?>
            </div>

            <div class="quiz-section">
                <h2>Pronto para testar seus conhecimentos?</h2>
                <p>Após estudar o material, clique no botão abaixo para fazer um pequeno quiz e validar seu aprendizado.</p>
                <a href="pagina-quiz.php?aula_id=<?php echo $aula['id_aula']; ?>" class="btn-quiz">
                    <i class="bi bi-check2-circle"></i> Iniciar Quiz
                </a>
            </div>
        </div>
    </div>

    <!-- SCRIPTS GLOBAIS REMOVIDOS DAQUI -->
    
</body>
</html>
