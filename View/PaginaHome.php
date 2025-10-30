<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAI - Página Principal</title>
    <!-- Links para Bootstrap e CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../Templates/css/PaginaHome.css">
</head>

<body>
    <!-- =============================================== -->
    <!--               SIDEBAR LATERAL (ORIGINAL )        -->
    <!-- =============================================== -->
    <div class="sidebar">
        <img src="../Images/Ícones do header/Logo ClassAI branca.png" alt="Imagem logo ClassAII" class="img-logo">

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="bi bi-house-door"></i>
                    Principal
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-chat"></i>
                    Chat
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-book"></i>
                    Cursos
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-award"></i>
                    Certificados
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-people"></i>
                    Amigos
                </a>
            </li>
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

    <!-- =============================================== -->
    <!--            CONTEÚDO PRINCIPAL E HEADER          -->
    <!-- =============================================== -->
    <div class="main-content">
        <!-- Header (ORIGINAL) -->
        <header class="header">
            <div></div> <!-- Este div vazio estava no seu código original para espaçamento -->
            <div class="header-icons">
                <div class="header-icon">
                    <img src="../Images/Ícones do header/lazzo.png" alt="Imagem lazzo" class="lazzo_img">
                </div>
                <div class="header-icon">
                    <i class="bi bi-bell"></i>
                </div>

                <div class="user-profile">
                    <img src="https://via.placeholder.com/40" alt="Avatar do Usuário" class="user-avatar">
                    <img src="../Images/Ícones do header/setinha perfil.png" alt="Seta" class="arrow-icon">
                </div>
            </div>
            <div class="header_mobile">
                <img src="../Images/Ícones do header/Logo ClassAI branca.png" alt="Imagem logo ClassAII"
                    class="img-logo">
                <i class="bi bi-list"></i>
            </div>
        </header>

        <!-- =============================================== -->
        <!--     CONTEÚDO DA PÁGINA (ESTRUTURA REFINADA )     -->
        <!-- =============================================== -->
        <main class="container-fluid">
            <h1 class="main-title mb-4">Página Principal</h1>

            <div class="row g-4">
                <!-- Coluna Principal (Esquerda) -->
                <div class="col-lg-8">
                    <!-- Card de Perfil -->
                    <section class="profile-card-main mb-4">
                        <div class="profile-intro">
                            <h2 class="user-name">
                                <span class="decorated-name">Jeferson Souza</span>
                            </h2>
                            <p class="user-course">Aluno - Técnico em Logística</p>
                        </div>

                        <div class="consistency-badge">
                            <img src="../Images/Página Inicial/CerebroConstancia.png" alt="Ícone de cérebro"
                                class="brain-icon">
                            <div class="consistency-content">
                                <span class="consistency-days">80</span>
                                <span class="consistency-text">Dias de Constância</span>
                            </div>
                        </div>
                    </section>


                    <!-- Cards de Resumo -->
                    <!-- Cards de Resumo (ATUALIZADO) -->
                    <section class="row g-4 mb-4">
                        <div class="col-md-6">
                            <!-- O card agora é um link -->
                            <a href="#" class="summary-card">
                                <div class="card-icon-wrapper concluded">
                                    <i class="bi bi-mortarboard-fill"></i>
                                </div>
                                <div class="summary-info">
                                    <h3 class="summary-title">Cursos Concluídos</h3>
                                    <p class="summary-count">3 Cursos</p>
                                    <!-- O link "veja mais" foi removido -->
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <!-- O card agora é um link -->
                            <a href="#" class="summary-card">
                                <div class="card-icon-wrapper in-progress">
                                    <i class="bi bi-book-half"></i>
                                </div>
                                <div class="summary-info">
                                    <h3 class="summary-title">Cursos em Andamento</h3>
                                    <p class="summary-count">2 Cursos</p>
                                
                                </div>
                            </a>
                        </div>
                    </section>

                    <!-- Cursos em Tendência -->
                <!-- Cursos em Tendência (ATUALIZADO) -->
<section>
    <header class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="section-title">Cursos em tendência</h3>
        <!-- Botão "Ver mais" e navegação agrupados -->
        <div class="section-header-actions">
            <a href="#" class="btn-view-more">Ver mais</a>
            <div class="carousel-nav">
                <a href="#" class="btn-carousel-nav" aria-label="Anterior"><i class="bi bi-chevron-left"></i></a>
                <a href="#" class="btn-carousel-nav active" aria-label="Próximo"><i class="bi bi-chevron-right"></i></a>
            </div>
        </div>
    </header>
    <div class="row g-4">
        <!-- Card 1 -->
        <div class="col-md-6 col-xl-4">
            <article class="course-card">
                <img src="https://i.imgur.com/Lz2d6fM.png" class="card-img-top" alt="Curso ChatGPT">
                <div class="card-body">
                    <h4 class="course-title">ChatGPT no dia a dia: Automatize tarefas com texto</h4>
                    <!-- Informações do instrutor com avatar -->
                    <div class="course-instructor-info">
                        <img src="https://i.imgur.com/S2ankoG.png" alt="Avatar Aline Santos" class="instructor-avatar">
                        <span class="course-instructor">Aline Santos</span>
                    </div>
                    <button class="btn btn-enroll w-100">Matricular-me</button>
                </div>
            </article>
        </div>
        <!-- Card 2 -->
        <div class="col-md-6 col-xl-4">
            <article class="course-card">
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
        <!-- Card 3 -->
        <div class="col-md-6 col-xl-4">
             <article class="course-card">
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

                <!-- Coluna Lateral (Direita ) -->
                <div class="col-lg-4">
                    <!-- Cursos em Andamento (Lateral) -->
                    <section class="right-section-card mb-4">
                        <h3 class="section-title mb-3"><i class="bi bi-journals"></i> Cursos em Andamento</h3>
                        <ul class="list-unstyled">
                            <li class="course-list-item">IA para Pequenos Empreendedores</li>
                            <li class="course-list-item">IA para Profissionais de RH</li>
                            <li class="course-list-item">IA para Vendedores e Atendimento ao Cliente</li>
                            <li class="course-list-item">IA para Designers: Crie Artes e Protótipos</li>
                        </ul>
                    </section>

                    <!-- Chat -->
                    <section class="right-section-card">
                        <h3 class="section-title mb-3"><i class="bi bi-chat-dots-fill"></i> Chat</h3>
                        <ul class="list-unstyled">
                            <li class="chat-item">
                                <img src="https://i.imgur.com/johG9Yt.png" alt="Avatar Professor João">
                                <div class="chat-info">
                                    <span class="chat-name">Professor João</span>
                                    <span class="chat-message">Professor, eu gostaria de tirar...</span>
                                </div>
                                <time class="chat-time">22h00</time>
                            </li>
                            <li class="chat-item">
                                <img src="https://i.imgur.com/S2ankoG.png" alt="Avatar Professor Cleber">
                                <div class="chat-info">
                                    <span class="chat-name">Professor Cleber</span>
                                    <span class="chat-message">Obrigado pela resposta!</span>
                                </div>
                                <time class="chat-time">19h30</time>
                            </li>
                            <li class="chat-item">
                                <img src="https://i.imgur.com/I9X1LpA.png" alt="Avatar José Felipe">
                                <div class="chat-info">
                                    <span class="chat-name">José Felipe</span>
                                    <span class="chat-message">Rapaz, a situação é complica...</span>
                                </div>
                                <time class="chat-time">12h00</time>
                            </li>
                            <li class="chat-item">
                                <img src="https://i.imgur.com/johG9Yt.png" alt="Avatar Professor Yago">
                                <div class="chat-info">
                                    <span class="chat-name">Professor Yago</span>
                                    <span class="chat-message">A atividade está incompleta</span>
                                </div>
                                <time class="chat-time">8h00</time>
                            </li>
                        </ul>
                    </section>
                </div>
            </div>
        </main>
    </div>

    <!-- Scripts JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../Templates/js/PaginaHome.js"></script>
</body>

</html>