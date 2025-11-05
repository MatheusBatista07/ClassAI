<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAI | (Nome do curso)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../Templates/css/pagina-curso.css">
    <link rel="stylesheet" href="../Templates/css/notificacao.css">
</head>

<body>

    <!-- 1. SIDEBAR (Barra Lateral ) -->
    <div class="sidebar">
        <img src="../Images/Ícones do header/Logo ClassAI branca.png" alt="Logo ClassAI" class="img-logo">
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

    <!-- 2. MAIN CONTENT (TODA a área principal da página) -->
    <div class="main-content">

        <!-- 2.1. HEADER (Cabeçalho) -->
        <div class="header">
            <div></div> <!-- Elemento para alinhamento dos ícones à direita -->
            <div class="header-icons">
                <div class="header-icon"><img src="../Images/Ícones do header/lazzo.png" alt="Ícone Lazzo" class="lazzo_img"></div>
                <div class="header-icon notification-icon-container">
                    <i class="bi bi-bell" id="notification-bell"></i>
                    <div class="notification-dot" id="notification-dot"></div>
                </div>
                <div class="user-profile">
                    <img src="https://via.placeholder.com/40" alt="Avatar do Usuário" class="user-avatar">
                    <img src="../Images/Ícones do header/setinha perfil.png" alt="Seta" class="arrow-icon">
                </div>
            </div>
        </div>

        <!-- 2.2. CONTEÚDO DO CURSO (Dentro do main-content ) -->
        <div class="conteudo__principal">
            <!-- Coluna da Esquerda -->
            <div class="left-column">
                <header>
                    <h1 style="font-weight:700;">Chat GPT no dia a dia: Automatize tarefas com texto</h1>
                    <div class="hero-image-responsive"><img src="../Images/Página do Curso/imagem_curso.png" alt="Ambiente de trabalho com um laptop"></div>
                    <div class="info-line">
                        <p><img class="icon-text" src="../Images/Página do Curso/ícone lapis.png" alt="lápis"> Professor João Gomes</p>
                        <p>Nível de dificuldade: Iniciante</p>
                    </div>
                </header>

                <div class="header_mobile">
                    <img src="../Images/Ícones do header/Logo ClassAI branca.png" alt="Imagem logo ClassAII"
                        class="img-logo">

                    <div class="iconezinhos" style="display: flex; gap: 1.0rem">
                        <div class="header-icon notification-icon-container">
                            <i class="bi bi-bell" id="notification-bell-mobile"></i>
                            <div class="notification-dot" id="notification-dot-mobile"></div>
                        </div>
                        <i class="bi bi-list"></i>
                    </div>

                </div>


                <section class="description" style="font-weight: 200;">
                    <p>Descubra como usar o poder do ChatGPT para simplificar sua rotina! Neste curso prático, você aprenderá a automatizar tarefas do dia a dia utilizando comandos de texto inteligentes.</p>
                    <p>Desde escrever e-mails e organizar ideias até gerar relatórios, criar conteúdos e resolver problemas rapidamente – tudo com a ajuda da inteligência artificial. Ideal para quem quer ganhar tempo, aumentar a produtividade e transformar sua maneira de trabalhar com texto.</p>
                </section>
                <section class="modules">
                    <h2 style="color: white; font-weight: 700;">Módulos</h2>
                    <div class="modules-container">
                        <div class="modules-track"></div>
                    </div>
                </section>
            </div>
            <!-- Coluna da Direita -->
            <div class="right-column">
                <div class="hero-image"><img src="../Images/Página do Curso/imagem_curso.png" alt="Ambiente de trabalho com um laptop"></div>
                <button class="cta-button">Inscreva-se</button>
                <div class="target-audience">
                    <h3>Para quem é...</h3>
                    <ul>
                        <li>Marketing e Comunicação</li>
                        <li>Educação</li>
                        <li>Tecnologia (Dev, TI, etc.)</li>
                        <li>Saúde (com cuidado!)</li>
                        <li>Empreendedores e Freelancers</li>
                        <li>Criativos (escritores, artistas, designers)</li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- 2.3. POP-UP DE NOTIFICAÇÕES (Dentro do main-content para herdar o posicionamento) -->
        <div class="notifications-popup" id="notifications-popup">
            <div class="popup-header">
                <h2>Notificações</h2>
            </div>
            <div class="popup-tabs">
                <button class="tab-button active" data-tab="todas">Todas <span class="badge" id="todas-badge"></span></button>
            </div>
            <div class="popup-body" id="notification-list"></div>
        </div>

    </div> <!-- Fechamento CORRETO do .main-content -->

    <!-- 3. SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../Templates/js/pagina-curso.js"></script>
    <script src="../Templates/js/notificacao.js"></script>
    <script src="../Templates/js/globalPresence.js"></script>
</body>

</html>