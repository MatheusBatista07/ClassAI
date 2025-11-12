<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../Model/CursosModel.php';

use Model\CursosModel;

$cursoId = $_GET['curso_id'] ?? null;
if (!$cursoId) {
    die("Curso não especificado.");
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
    <title>Todos os Módulos: <?php echo htmlspecialchars($curso['nome_curso']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../Templates/css/pagina-curso.css"> <!-- Reutilizando o CSS -->
</head>
<body>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="PaginaPrincipalCursos.php">Cursos</a></li>
                <li class="breadcrumb-item"><a href="pagina-curso.php?id=<?php echo $curso['id_curso']; ?>"><?php echo htmlspecialchars($curso['nome_curso'] ); ?></a></li>
                <li class="breadcrumb-item active" aria-current="page">Todos os Módulos</li>
            </ol>
        </nav>

        <h1 class="mb-4">Todos os Módulos</h1>

        <div class="row g-4">
            <?php if (empty($modulos)): ?>
                <p>Nenhum módulo encontrado para este curso.</p>
            <?php else: ?>
                <?php foreach ($modulos as $index => $modulo): ?>
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <a href="pagina-modulo.php?mod_id=<?php echo $modulo['id_mod']; ?>" class="module-card-link">
                            <div class="module-card">
                                <img src="/ClassAI/<?php echo htmlspecialchars($modulo['capa_mod']); ?>" class="card-img-top" alt="Capa do <?php echo htmlspecialchars($modulo['titulo_mod']); ?>">
                                <div class="card-body">
                                    <span class="module-number">Módulo <?php echo $index + 1; ?></span>
                                    <h5 class="card-title"><?php echo htmlspecialchars($modulo['titulo_mod']); ?></h5>
                                    <div class="card-info">
                                        <span><i class="bi bi-collection-play"></i> <?php echo $modulo['total_aulas']; ?> Aulas</span>
                                        <span><i class="bi bi-clock"></i> <?php echo htmlspecialchars($modulo['duracao_mod']); ?></span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
