<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../Controller/CursosController.php';
require_once __DIR__ . '/../Model/UserModel.php';

use Controller\CursosController;
use Model\UserModel;

$cursoController = new CursosController();
$cursos = $cursoController->getCoursesForUser();

$userId = $_SESSION['usuario_id'] ?? null;
$userModel = new UserModel();
$usuarioLogado = $userModel->encontrarUsuarioPorId($userId);
$fotoUsuario = !empty($usuarioLogado['foto_perfil_url']) ? '/ClassAI/' . htmlspecialchars($usuarioLogado['foto_perfil_url']) : 'https://via.placeholder.com/40';
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAI - Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../Templates/css/Cursos.css">
</head>

<body>
    <div class="sidebar">
        <img src="../Images/Icones-do-header/Logo-ClassAI-branca.png" alt="Imagem logo ClassAII" class="img-logo">
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
                <div class="header-icon"><img src="../Images/Icones-do-header/lazzo.png" alt="Imagem lazzo" class="lazzo_img"></div>
                <div class="header-icon"><i class="bi bi-bell"></i></div>
                <div class="user-profile">
                    <img src="<?php echo $fotoUsuario; ?>" alt="Avatar do Usuário" class="user-avatar">
                    <img src="../Images/Icones-do-header/setinha-perfil.png" alt="Seta" class="arrow-icon">
                </div>
            </div>
            <div class="header_mobile">
                <img src="../Images/Icones-do-header/Logo-ClassAI-branca.png" alt="Imagem logo ClassAII" class="img-logo">
                <i class="bi bi-list"></i>
            </div>
        </div>
        <div class="cima">
            <h1>Página de Cursos</h1>
            <div class="org">
                <div class="pesquisa">
                    <input type="text" id="search-input" placeholder="Pesquisar por nome ou professor...">
                </div>
                <div class="filtro">
                    <p>Filtrar</p>
                </div>
            </div>
        </div>

        <div class="courses-section">
            <div id="courses-list" class="courses-list">
                <?php if (empty($cursos )): ?>
                    <p class="loading">Nenhum curso encontrado.</p>
                <?php else: ?>
                    <?php foreach ($cursos as $curso): ?>
                        <div class="course-card" 
                             data-title="<?php echo htmlspecialchars(strtolower($curso['nome_curso'])); ?>" 
                             data-prof="<?php echo htmlspecialchars(strtolower($curso['prof_curso'])); ?>"
                             data-course-id="<?php echo $curso['id_curso']; ?>">
                            <div class="course-image">
                                <a href="pagina-curso.php?id=<?php echo $curso['id_curso']; ?>">
                                    <img src="/ClassAI/<?php echo htmlspecialchars($curso['capa_curso']); ?>" alt="Capa do curso <?php echo htmlspecialchars($curso['nome_curso']); ?>">
                                </a>
                                <?php
                                $dificuldade_sem_acento = preg_replace('/[^A-Za-z0-9\-]/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $curso['dificuldade']));
                                $dificuldade_class = strtolower($dificuldade_sem_acento);
                                ?>
                                <span class="course-difficulty <?php echo $dificuldade_class; ?>">
                                    <?php echo htmlspecialchars($curso['dificuldade']); ?>
                                </span>
                            </div>

                            <div class="course-content">
                                <h3 class="course-title"><?php echo htmlspecialchars($curso['nome_curso']); ?></h3>
                                <div class="course-instructor">
                                    <img src="<?php echo htmlspecialchars($curso['prof_foto_url']); ?>" alt="Foto de <?php echo htmlspecialchars($curso['prof_curso']); ?>">
                                    <span><?php echo htmlspecialchars($curso['prof_curso']); ?></span>
                                </div>
                                
                                <?php
                                $status = $curso['status'] ?? 'Disponível';
                                if ($status === 'Em andamento' || $status === 'Concluído'): ?>
                                    <a href="pagina-curso.php?id=<?php echo $curso['id_curso']; ?>" class="course-button status-inprogress">Continuar Curso</a>
                                <?php else: ?>
                                    <button class="course-button status-available btn-enroll">Matricular-me</button>
                                <?php endif; ?>

                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        <img class="lazinho" src="../Images/Pagina-do-Curso/lazo_inclinado.png" alt="Mascote lazo inclinado">
    </div>

        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="../Templates/js/globalPresence.js"></script>
    <script src="../Templates/js/PaginaPrincipalCursos.js"></script> 
</body>

</html>
