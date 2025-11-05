<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../Model/UserModel.php';
require_once __DIR__ . '/../Model/CursosModel.php';
require_once __DIR__ . '/../Model/ChatModel.php';

$userId = $_SESSION['usuario_id'];

$userModel = new \Model\UserModel();
$usuario = $userModel->encontrarUsuarioPorId($userId);

$cursosModel = new CursosModel();
$inscricoes = $cursosModel->getInscricoesByUserId($userId);

$cursosEmAndamento = array_filter($inscricoes, fn($status) => $status === 'Em andamento');
$cursosConcluidos = array_filter($inscricoes, fn($status) => $status === 'Concluído');
$numCursosEmAndamento = count($cursosEmAndamento);
$numCursosConcluidos = count($cursosConcluidos);

$nomeCompleto = trim(($usuario['nome'] ?? '') . ' ' . ($usuario['sobrenome'] ?? ''));
$primeiroNome = $usuario['nome'] ?? 'Usuário';
$funcaoUsuario = $usuario['funcao'] ?? 'aluno';

$caminhoFoto = $usuario['foto_perfil_url'] ?? null;
if ($caminhoFoto) {
    $fotoUsuario = '/ClassAI/' . $caminhoFoto;
} else {
    $fotoUsuario = 'https://via.placeholder.com/40';
}

$chatModel = new \Model\ChatModel();
$conversasRecentes = $chatModel->getRecentConversations($userId, 4);

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAI - Página Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../Templates/css/PaginaHome.css">
</head>

<body data-user-id="<?php echo htmlspecialchars($userId); ?>">
    <div class="sidebar">
        <img src="../Images/Ícones do header/Logo ClassAI branca.png" alt="Imagem logo ClassAII" class="img-logo">

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="PaginaHome.php" class="nav-link active"><i class="bi bi-house-door"></i> Principal</a>
            </li>
            <li class="nav-item">
                <a href="paginaChat.php" class="nav-link"><i class="bi bi-chat"></i> Chat</a>
            </li>
            <li class="nav-item">
                <a href="PaginaPrincipalCursos.php" class="nav-link"><i class="bi bi-book"></i> Cursos</a>
            </li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-award"></i> Certificados</a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-people"></i> Amigos</a></li>
        </ul>

        <div class="nav-divider"></div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-question-circle"></i>
                    Ajuda e FAQ
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    Modo escuro
                    <i class="bi bi-moon-stars ms-auto"></i>
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <header class="header">
            <div></div>
            <div class="header-icons">
                <div class="header-icon">
                    <img src="../Images/Ícones do header/lazzo.png" alt="Imagem lazzo" class="lazzo_img">
                </div>
                <div class="header-icon">
                    <i class="bi bi-bell"></i>
                </div>

                <div class="user-profile">
                    <img src="<?php echo htmlspecialchars($fotoUsuario); ?>" alt="Avatar de <?php echo htmlspecialchars($nomeCompleto); ?>" class="user-avatar">
                    <img src="../Images/Ícones do header/setinha perfil.png" alt="Seta" class="arrow-icon">
                </div>
            </div>
            <div class="header_mobile">
                <img src="../Images/Ícones do header/Logo ClassAI branca.png" alt="Imagem logo ClassAII" class="img-logo">
                <i class="bi bi-list"></i>
            </div>
        </header>

        <main class="container-fluid">
            <h1 class="main-title mb-4">Olá, <?php echo htmlspecialchars($primeiroNome); ?>!</h1>

            <div class="row g-4">
                <div class="col-lg-8">
                    <section class="profile-card-main mb-4">
                        <div class="profile-intro">
                            <h2 class="user-name">
                                <span class="decorated-name"><?php echo htmlspecialchars($nomeCompleto); ?></span>
                            </h2>
                            <p class="user-course"><?php echo htmlspecialchars(ucfirst($funcaoUsuario)); ?></p>
                        </div>

                        <div class="consistency-badge">
                            <img src="../Images/Página Inicial/CerebroConstancia.png" alt="Ícone de cérebro" class="brain-icon">
                            <div class="consistency-content">
                                <span class="consistency-days">80</span>
                                <span class="consistency-text">Dias de Constância</span>
                            </div>
                        </div>
                    </section>

                    <section class="row g-4 mb-4">
                        <div class="col-md-6">
                            <a href="#" class="summary-card">
                                <div class="card-icon-wrapper concluded">
                                    <i class="bi bi-mortarboard-fill"></i>
                                </div>
                                <div class="summary-info">
                                    <h3 class="summary-title">Cursos Concluídos</h3>
                                    <p class="summary-count"><?php echo $numCursosConcluidos; ?> Cursos</p>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="summary-card">
                                <div class="card-icon-wrapper in-progress">
                                    <i class="bi bi-book-half"></i>
                                </div>
                                <div class="summary-info">
                                    <h3 class="summary-title">Cursos em Andamento</h3>
                                    <p class="summary-count"><?php echo $numCursosEmAndamento; ?> Cursos</p>
                                </div>
                            </a>
                        </div>
                    </section>

                    <section>
                        <header class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="section-title">Cursos em tendência</h3>
                            <div class="section-header-actions">
                                <a href="PaginaPrincipalCursos.php" class="btn-view-more">Ver mais</a>
                                <div class="carousel-nav">
                                    <a href="#" class="btn-carousel-nav" aria-label="Anterior"><i class="bi bi-chevron-left"></i></a>
                                    <a href="#" class="btn-carousel-nav active" aria-label="Próximo"><i class="bi bi-chevron-right"></i></a>
                                </div>
                            </div>
                        </header>
                        <div class="row g-4">
                            <div class="col-md-6 col-xl-4">
                                <article class="course-card" data-course-id="1">
                                    <img src="https://i.imgur.com/Lz2d6fM.png" class="card-img-top" alt="Curso ChatGPT">
                                    <div class="card-body">
                                        <h4 class="course-title">ChatGPT no dia a dia: Automatize tarefas com texto</h4>
                                        <div class="course-instructor-info">
                                            <img src="https://i.imgur.com/S2ankoG.png" alt="Avatar Aline Santos" class="instructor-avatar">
                                            <span class="course-instructor">Aline Santos</span>
                                        </div>
                                        <button class="btn btn-enroll w-100">Matricular-me</button>
                                    </div>
                                </article>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <article class="course-card" data-course-id="2">
                                    <img src="https://i.imgur.com/uI9A9eM.png" class="card-img-top" alt="Curso IA para Leigos">
                                    <div class="card-body">
                                        <h4 class="course-title">Introdução à Inteligência Artificial para Leigos</h4>
                                        <div class="course-instructor-info">
                                            <img src="https://i.imgur.com/johG9Yt.png" alt="Avatar João Pedro" class="instructor-avatar">
                                            <span class="course-instructor">João Pedro</span>
                                        </div>
                                        <button class="btn btn-enroll w-100">Matricular-me</button>
                                    </div>
                                </article>
                            </div>
                            <div class="col-md-6 col-xl-4">
                                <article class="course-card" data-course-id="3">
                                    <img src="https://i.imgur.com/VvBvYyq.png" class="card-img-top" alt="Curso Prompt Engineering">
                                    <div class="card-body">
                                        <h4 class="course-title">Prompt Engineering para Iniciantes</h4>
                                        <div class="course-instructor-info">
                                            <img src="https://i.imgur.com/I9X1LpA.png" alt="Avatar Pedro Carlos" class="instructor-avatar">
                                            <span class="course-instructor">Pedro Carlos</span>
                                        </div>
                                        <button class="btn btn-enroll w-100">Matricular-me</button>
                                    </div>
                                </article>
                            </div>
                        </div>
                    </section>
                </div>

                <div class="col-lg-4">
                    <section class="right-section-card mb-4">
                        <h3 class="section-title mb-3"><i class="bi bi-journals"></i> Cursos em Andamento</h3>
                        <ul class="list-unstyled course-list-hover">
                            <li>
                                <a href="#" class="course-list-item">
                                    <img src="https://i.imgur.com/Lz2d6fM.png" alt="Capa do curso IA para Pequenos Empreendedores" class="course-item-image">
                                    <span>IA para Pequenos Empreendedores</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="course-list-item">
                                    <img src="https://i.imgur.com/uI9A9eM.png" alt="Capa do curso IA para Profissionais de RH" class="course-item-image">
                                    <span>IA para Profissionais de RH</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="course-list-item">
                                    <img src="https://i.imgur.com/VvBvYyq.png" alt="Capa do curso IA para Vendedores" class="course-item-image">
                                    <span>IA para Vendedores e Atendimento ao Cliente</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="course-list-item">
                                    <img src="https://i.imgur.com/johG9Yt.png" alt="Capa do curso IA para Designers" class="course-item-image">
                                    <span>IA para Designers: Crie Artes e Protótipos com Ferramentas de IA</span>
                                </a>
                            </li>
                        </ul>
                    </section>

                    <!-- SEÇÃO DO CHAT CORRIGIDA -->
                    <section class="right-section-card">
                        <h3 class="section-title mb-3"><i class="bi bi-chat-dots-fill"></i> Chat</h3>
                        <div class="chat-list-home">
                            <?php if (empty($conversasRecentes)): ?>
                                <p class="text-center text-muted p-3">Nenhuma conversa recente.</p>
                            <?php else: ?>
                                <?php foreach ($conversasRecentes as $conversa): ?>
                                    <?php
                                    $statusIcon = '';
                                    if ($conversa['id_remetente'] == $userId) {
                                        if ($conversa['status_leitura'] === 'lida') {
                                            $statusIcon = '<i class="bi bi-check2-all" style="color: #4fc3f7;"></i>';
                                        } else {
                                            $statusIcon = '<i class="bi bi-check2"></i>';
                                        }
                                    }
                                    $timestamp = new DateTime($conversa['timestamp']);
                                    $horaFormatada = $timestamp->format('H:i');
                                    $fotoContato = $conversa['foto_perfil_url'] ? '/ClassAI/' . $conversa['foto_perfil_url'] : 'https://via.placeholder.com/40';
                                    $nomeContato = htmlspecialchars($conversa['nome'] . ' ' . $conversa['sobrenome']);
                                    ?>
                                    <a href="paginaChat.php?contactId=<?php echo $conversa['contact_id']; ?>" class="chat-list-link">
                                        <div class="chat-item" data-contact-id="<?php echo $conversa['contact_id']; ?>" data-contact-status="offline">
                                            <div class="chat-avatar-container">
                                                <img src="<?php echo htmlspecialchars($fotoContato); ?>" alt="Avatar de <?php echo $nomeContato; ?>">
                                                <div class="status-indicator"></div>
                                            </div>
                                            <div class="chat-info">
                                                <span class="chat-name"><?php echo $nomeContato; ?></span>
                                                <div class="message-preview">
                                                    <div class="read-status"><?php echo $statusIcon; ?></div>
                                                    <span class="chat-message"><?php echo htmlspecialchars($conversa['ultima_mensagem']); ?></span>
                                                </div>
                                            </div>
                                            <time class="chat-time"><?php echo $horaFormatada; ?></time>
                                        </div>
                                    </a>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </section>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="../Templates/js/globalPresence.js"></script>
    <script src="../Templates/js/PaginaHome.js"></script>
</body>

</html>