<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../Model/CursosModel.php';

use Model\CursosModel;

$userId = $_SESSION['usuario_id'] ?? null;
$cursoId = $_GET['curso_id'] ?? null;

if (!$cursoId || !$userId) {
    header('Location: PaginaHome.php');
    exit;
}

$cursosModel = new CursosModel();
$curso = $cursosModel->getCourseById((int)$cursoId);
$modulos = $cursosModel->getModulosEAulasPorCursoId((int)$cursoId);

if (!$curso) {
    die("Curso não encontrado.");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulos de <?php echo htmlspecialchars($curso['nome_curso'] ); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/ClassAI/Templates/css/pagina-modulos.css">
</head>

<body>

    <?php require_once __DIR__ . '/_sidebar.php'; // AGORA USANDO A SIDEBAR UNIVERSAL ?>

    <div class="main-content">
        
        <?php require_once __DIR__ . '/_header.php'; // AGORA USANDO O HEADER UNIVERSAL ?>

        <div class="course-content-area">
            <a href="pagina-curso.php?id=<?php echo $curso['id_curso']; ?>" class="btn-voltar">
                <i class="bi bi-arrow-left-circle"></i> Voltar para o Curso
            </a>

            <header class="course-header">
                <h1><?php echo htmlspecialchars($curso['nome_curso']  ); ?></h1>
                <h2>Todos os Módulos</h2>
            </header>

            <div class="modules-grid-container">
                <?php if (empty($modulos)): ?>
                    <p class="text-white-50">Nenhum módulo encontrado para este curso.</p>
                <?php else: ?>
                    <?php foreach ($modulos as $index => $modulo): ?>
                        <a href="pagina-modulo.php?mod_id=<?php echo $modulo['id_mod']; ?>" class="module-card">
                            <div class="module-image-container">
                                <img src="/ClassAI/<?php echo htmlspecialchars($modulo['capa_mod']); ?>" alt="Capa do <?php echo htmlspecialchars($modulo['titulo_mod']); ?>">
                            </div>
                            <div class="module-content">
                                <h3><i class="bi bi-journal-bookmark"></i> Módulo <?php echo $index + 1; ?></h3>
                                <p><?php echo htmlspecialchars($modulo['titulo_mod']); ?></p>
                                <div class="duration">
                                    <i class="bi bi-clock"></i> <?php echo htmlspecialchars($modulo['duracao_mod']); ?>
                                </div>
                            </div>
                        </a>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- SCRIPTS GLOBAIS REMOVIDOS DAQUI -->

</body>
</html>
