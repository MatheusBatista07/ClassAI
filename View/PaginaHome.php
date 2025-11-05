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

<body>
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
                    <img src="../Images/Página Inicial/Reynan.webp" alt="Avatar do Usuário" class="user-avatar">
                    <img src="../Images/Ícones do header/setinha perfil.png" alt="Seta" class="arrow-icon">
                </div>
            </div>
            <div class="header_mobile">
                <img src="../Images/Ícones do header/Logo ClassAI branca.png" alt="Imagem logo ClassAII"
                    class="img-logo">
                <i class="bi bi-list"></i>
            </div>
        </header>

        <main class="container-fluid">
            <h1 class="main-title mb-4">Página Principal</h1>

            <div class="row g-4">
                <div class="col-lg-8">
                    <section class="profile-card-main mb-4">
                        <div class="profile-intro">
                            <div class="user-title-line">
                                <h2 class="user-name">
                                    <span class="decorated-name">Jeferson Souza</span>
                                </h2>
                                <div class="mood-face-container">
                                    <img src="../Images/Página Inicial/carinha feliz.png" alt="Humor da constância"
                                        class="mood-face">
                                </div>
                            </div>
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

                    <section class="row g-4 mb-4">
                        <div class="col-md-6">
                            <a href="#" class="summary-card">
                                <div class="card-icon-wrapper concluded">
                                    <i class="bi bi-mortarboard-fill"></i>
                                </div>
                                <div class="summary-info">
                                    <h3 class="summary-title">Cursos Concluídos</h3>
                                    <p class="summary-count">3 Cursos</p>
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
                                    <p class="summary-count">2 Cursos</p>
                                </div>
                            </a>
                        </div>
                    </section>

                    <section>
                        <header class="d-flex justify-content-between align-items-center mb-3">
                            <h3 class="section-title">Cursos em tendência</h3>
                            <div class="section-header-actions">
                                <a href="#" class="btn-view-more">Ver mais</a>
                                <div class="carousel-nav">
                                    <a href="#" class="btn-carousel-nav" aria-label="Anterior"><i
                                            class="bi bi-chevron-left"></i></a>
                                    <a href="#" class="btn-carousel-nav active" aria-label="Próximo"><i
                                            class="bi bi-chevron-right"></i></a>
                                </div>
                            </div>
                        </header>
                        
                        <!-- LOCAL CORRETO PARA O LOOP DOS CURSOS -->
                        <div class="row g-4">
                            <?php 
                            // Supondo que a variável $cursos venha do seu controller
                            // Se não houver cursos, você pode colocar um 'else' ou simplesmente não mostrar nada.
                            if (isset($cursos ) && !empty($cursos)):
                                foreach ($cursos as $curso): 
                            ?>
                                <div class="col-6 col-md-6 col-xl-4">
                                    <article class="course-card" data-course-id="<?php echo htmlspecialchars($curso['id']); ?>">
                                        <img src="<?php echo htmlspecialchars($curso['imagem_url']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($curso['titulo']); ?>">
                                        <div class="card-body">
                                            <h4 class="course-title"><?php echo htmlspecialchars($curso['titulo']); ?></h4>
                                            <div class="course-instructor-info">
                                                <img src="<?php echo htmlspecialchars($curso['instrutor_avatar']); ?>" alt="Avatar" class="instructor-avatar">
                                                <span class="course-instructor"><?php echo htmlspecialchars($curso['instrutor_nome']); ?></span>
                                            </div>
                                            <button class="btn btn-enroll w-100">Matricular-me</button>
                                        </div>
                                    </article>
                                </div>
                            <?php 
                                endforeach;
                            else:

                                echo "<p>Nenhum curso em tendência no momento.</p>";
                            endif;
                            ?>
                        </div>
                    </section>

                </div>

                <div class="col-lg-4">
                    <section class="right-section-card mb-4">
                        <h3 class="section-title mb-3"><i class="bi bi-journals"></i> Cursos em Andamento</h3>
                        <ul class="list-unstyled course-list-hover">
                            <li>
                                <a href="#" class="course-list-item">
                                    <img src="https://i.imgur.com/Lz2d6fM.png"
                                        alt="Capa do curso IA para Pequenos Empreendedores" class="course-item-image">
                                    <span>IA para Pequenos Empreendedores</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="course-list-item">
                                    <img src="https://i.imgur.com/uI9A9eM.png"
                                        alt="Capa do curso IA para Profissionais de RH" class="course-item-image">
                                    <span>IA para Profissionais de RH</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="course-list-item">
                                    <img src="https://i.imgur.com/VvBvYyq.png" alt="Capa do curso IA para Vendedores"
                                        class="course-item-image">
                                    <span>IA para Vendedores e Atendimento ao Cliente</span>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="course-list-item">
                                    <img src="https://i.imgur.com/johG9Yt.png" alt="Capa do curso IA para Designers"
                                        class="course-item-image">
                                    <span>IA para Designers: Crie Artes e Protótipos com Ferramentas de IA</span>
                                </a>
                            </li>
                        </ul>
                    </section>

                    <section class="right-section-card">
                        <h3 class="section-title mb-3"><i class="bi bi-chat-dots-fill"></i> Chat</h3>
                        <ul class="list-unstyled">
                            <li class="chat-item sent">
                                <img src="https://i.imgur.com/johG9Yt.png" alt="Avatar Professor João">
                                <div class="chat-info">
                                    <span class="chat-name">Professor João</span>
                                    <div class="message-preview">
                                        <div class="read-status"><i class="bi bi-check"></i></div>
                                        <span class="chat-message">Ok, vou verificar e te retorno.</span>
                                    </div>
                                </div>
                                <time class="chat-time">12h00</time>
                            </li>
                            <li class="chat-item delivered">
                                <img src="https://i.imgur.com/S2ankoG.png" alt="Avatar Professor Cleber">
                                <div class="chat-info">
                                    <span class="chat-name">Professor Cleber</span>
                                    <div class="message-preview">
                                        <div class="read-status"><i class="bi bi-check2-all"></i></div>
                                        <span class="chat-message">Obrigado pelo retorno!</span>
                                    </div>
                                </div>
                                <time class="chat-time">11h30</time>
                            </li>
                            <li class="chat-item read">
                                <img src="https://i.imgur.com/I9X1LpA.png" alt="Avatar José Felipe">
                                <div class="chat-info">
                                    <span class="chat-name">José Felipe</span>
                                    <div class="message-preview">
                                        <div class="read-status"><i class="bi bi-check2-all"></i></div>
                                        <span class="chat-message">Rapaz, a situação é complica...</span>
                                    </div>
                                </div>
                                <time class="chat-time">10h30</time>
                            </li>
                        </ul>
                    </section>
                </div>
            </div>
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../Templates/js/PaginaHome.js"></script>
</body>

</html>
