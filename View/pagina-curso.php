<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../Model/CursosModel.php';
require_once __DIR__ . '/../Model/UserModel.php';

use Model\CursosModel;
use Model\UserModel;

$userId = $_SESSION['usuario_id'] ?? null;
$cursoId = $_GET['id'] ?? null;

if (!$cursoId || !$userId) {
    die("Acesso inválido.");
}

$cursosModel = new CursosModel();
$curso = $cursosModel->getCourseById((int)$cursoId);

if (!$curso) {
    die("Curso não encontrado.");
}

$userModel = new UserModel();
$usuarioLogado = $userModel->encontrarUsuarioPorId($userId);
$fotoUsuario = !empty($usuarioLogado['foto_perfil_url']) ? '/ClassAI/' . htmlspecialchars($usuarioLogado['foto_perfil_url']) : 'https://via.placeholder.com/40';

$inscricoes = $cursosModel->getInscricoesByUserId($userId );
$estaInscrito = isset($inscricoes[$cursoId]);

$modulos = $cursosModel->getModulosEAulasPorCursoId((int)$cursoId);

$imagemCurso = $curso['capa_curso'] ? '/ClassAI/' . htmlspecialchars($curso['capa_curso']) : 'https://via.placeholder.com/800x450';
$imagemProfessor = $curso['prof_foto_url'] ? htmlspecialchars($curso['prof_foto_url'] ) : 'https://via.placeholder.com/24';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAI | <?php echo htmlspecialchars($curso['nome_curso'] ); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../Templates/css/pagina-curso.css">
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

        <div class="conteudo__principal" data-course-id="<?php echo $curso['id_curso']; ?>">
            <div class="left-column">

                <a href="PaginaPrincipalCursos.php" class="btn-voltar mb-4">
                    <i class="bi bi-arrow-left"></i> Voltar para Cursos
                </a>

                <header>
                    <h1 style="font-weight:700;"><?php echo htmlspecialchars($curso['nome_curso'] ); ?></h1>
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
                        <?php if (empty($modulos)): ?>
                            <p class="text-white-50">Nenhum módulo encontrado para este curso.</p>
                        <?php else: ?>
                            <?php foreach (array_slice($modulos, 0, 3) as $index => $modulo): ?>
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
                
                <?php if ($estaInscrito): ?>
                    <button class="cta-button btn-danger btn-enroll enrolled">Cancelar Inscrição</button>
                <?php else: ?>
                    <button class="cta-button btn-primary btn-enroll">Inscreva-se</button>
                <?php endif; ?>

                <?php if (!empty($curso['publico_alvo'])): ?>
                    <div class="target-audience">
                        <h3>Para quem é...</h3>
                        <ul>
                            <?php 
                            $publicoAlvo = explode(';', $curso['publico_alvo']);
                            foreach ($publicoAlvo as $item): ?>
                                <li><?php echo htmlspecialchars(trim($item)); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../Templates/js/pagina-curso.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="../Templates/js/globalPresence.js"></script>

</body>

</html>
