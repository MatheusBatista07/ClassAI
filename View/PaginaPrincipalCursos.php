<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../Controller/CursosController.php';
// UserModel já é chamado no _header.php, mas podemos manter por clareza
require_once __DIR__ . '/../Model/UserModel.php';

use Controller\CursosController;

$cursoController = new CursosController();
$cursos = $cursoController->getCoursesForUser();

// A lógica para buscar $usuarioLogado e $fotoUsuario foi movida para o _header.php
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAI - Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="/ClassAI/Templates/css/Cursos.css">
</head>

<body>
    <?php
        // Inclui a sidebar universal
        require_once __DIR__ . '/_sidebar.php';
    ?>

    <div class="main-content">
        <?php
            // Inclui o header universal (que também carrega o globalPresence_v2.js )
            require_once __DIR__ . '/_header.php';
        ?>

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
                <?php if (empty($cursos)): ?>
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
        <img class="lazinho" src="/ClassAI/Images/Pagina-do-Curso/lazo_inclinado.png" alt="Mascote lazo inclinado">
    </div>

    <!-- Os scripts globais (Pusher, globalPresence) são carregados pelo _header.php -->
    <!-- Apenas o script específico da página fica aqui -->
    <script src="/ClassAI/Templates/js/PaginaPrincipalCursos.js"></script> 
</body>

</html>
