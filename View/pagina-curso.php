<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../Model/CursosModel.php';

use Model\CursosModel;

$userId = $_SESSION['usuario_id'] ?? null;
$cursoId = $_GET['id'] ?? null;

if (!$cursoId || !$userId) {
    header('Location: PaginaHome.php');
    exit;
}

$cursosModel = new CursosModel();
$curso = $cursosModel->getCourseById((int)$cursoId);

if (!$curso) {
    die("Curso não encontrado.");
}

$inscricoes = $cursosModel->getInscricoesByUserId($userId );
$estaInscrito = isset($inscricoes[$cursoId]);

$modulos = $cursosModel->getModulosEAulasPorCursoId((int)$cursoId);

$imagemCurso = $curso['capa_curso'] ? '/ClassAI/' . htmlspecialchars($curso['capa_curso']) : 'https://via.placeholder.com/800x450';
$imagemProfessor = $curso['prof_foto_url'] ? '/ClassAI/' . htmlspecialchars($curso['prof_foto_url']  ) : 'https://via.placeholder.com/24';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAI | <?php echo htmlspecialchars($curso['nome_curso']  ); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/ClassAI/Templates/css/pagina-curso.css">
</head>

<body>

    <?php require_once __DIR__ . '/_sidebar.php'; // AGORA USANDO A SIDEBAR UNIVERSAL ?>

    <div class="main-content">

        <?php require_once __DIR__ . '/_header.php'; // AGORA USANDO O HEADER UNIVERSAL ?>

        <div class="conteudo__principal" data-course-id="<?php echo $curso['id_curso']; ?>">
            <div class="left-column">

                <a href="PaginaPrincipalCursos.php" class="btn-voltar mb-4">
                    <i class="bi bi-arrow-left"></i> Voltar para Cursos
                </a>

                <header>
                    <h1 style="font-weight:700;"><?php echo htmlspecialchars($curso['nome_curso']  ); ?></h1>
                    <div class="hero-image-responsive"><img src="<?php echo $imagemCurso; ?>" alt="Capa do curso"></div>
                    <div class="info-line">
                        <p><img class="icon-text" src="<?php echo $imagemProfessor; ?>" alt="Professor"> <?php echo htmlspecialchars($curso['prof_curso']); ?></p>
                        <p>Nível de dificuldade: <?php echo htmlspecialchars($curso['dificuldade']); ?></p>
                    </div>
                </header>

                <section class="description" style="font-weight: 200;">
                    <p><?php echo nl2br(htmlspecialchars($curso['descricao_curso'])); ?></p>
                </section>

                <section class="modules">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 style="color: white; font-weight: 700; margin-bottom: 0;">Módulos</h2>
                        <a href="pagina-modulos.php?curso_id=<?php echo $curso['id_curso']; ?>" class="btn btn-outline-light btn-sm">Ver todos</a>
                    </div>

                    <div class="row g-4">
                        <?php if (empty($modulos)) : ?>
                            <p class="text-white-50">Nenhum módulo encontrado para este curso.</p>
                        <?php else : ?>
                            <?php foreach (array_slice($modulos, 0, 3) as $index => $modulo) : ?>
                                <div class="col-md-6 col-lg-4">
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
                </section>

            </div>
            <div class="right-column">
                <div class="hero-image"><img src="<?php echo $imagemCurso; ?>" alt="Capa do curso"></div>

                <?php if ($estaInscrito) : ?>
                    <form id="form-cancelar" method="POST" action="">
                        <input type="hidden" name="curso_id" value="<?php echo $cursoId; ?>">
                        <button type="button" id="btn-cancelar-inscricao" class="cta-button btn-danger">Cancelar Inscrição</button>
                    </form>
                <?php else : ?>
                    <form method="POST" action="../Controller/processarInscricao.php">
                        <input type="hidden" name="curso_id" value="<?php echo $cursoId; ?>">
                        <button type="submit" class="cta-button btn-primary">Inscreva-se</button>
                    </form>
                <?php endif; ?>

                <?php if (!empty($curso['publico_alvo'])) : ?>
                    <div class="target-audience">
                        <h3>Para quem é...</h3>
                        <ul>
                            <?php
                            $publicoAlvo = explode(';', $curso['publico_alvo']);
                            foreach ($publicoAlvo as $item) : ?>
                                <li><?php echo htmlspecialchars(trim($item)); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCancelamento" tabindex="-1" aria-labelledby="modalCancelamentoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background-color: #1a0a2e; color: white; border: 1px solid #4E008D;">
                <div class="modal-header" style="border-bottom: 1px solid #4E008D;">
                    <h5 class="modal-title" id="modalCancelamentoLabel">Confirmar Cancelamento</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Você tem certeza de que deseja cancelar sua inscrição neste curso? Esta ação não pode ser desfeita.</p>
                    <div class="mb-3">
                        <label for="motivoCancelamento" class="form-label">Gostaríamos de saber o motivo (opcional):</label>
                        <textarea class="form-control" id="motivoCancelamento" rows="3" placeholder="Ex: O conteúdo não era o que eu esperava, falta de tempo, etc." style="background-color: #2c1a4d; color: white; border-color: #4E008D;"></textarea>
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid #4E008D;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Ficar no Curso</button>
                    <button type="button" class="btn btn-danger" id="btnConfirmarCancelamento">Sim, cancelar inscrição</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/ClassAI/Templates/js/pagina-curso.js"></script>
    
    <!-- SCRIPTS GLOBAIS REMOVIDOS DAQUI -->

</body>
</html>
