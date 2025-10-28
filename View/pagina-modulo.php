<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAI - Aula</title>
    <!-- Links de CSS e Fontes (incluindo Font Awesome para ícones) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- CSS da página de módulos (reutilizaremos a base ) e o novo CSS da aula -->
    <link rel="stylesheet" href="../Templates/css/pagina-curso.css">
    <link rel="stylesheet" href="../Templates/css/pagina-modulo.css">
    <!-- CSS de Notificação -->
    <link rel="stylesheet" href="../Templates/css/notificacao.css">
</head>
<body>

    <!-- 1. SIDEBAR (Estrutura idêntica) -->
    <div class="sidebar">
        <img src="../Images/Ícones do header/Logo ClassAI branca.png" alt="Logo ClassAI" class="img-logo">
        <ul class="nav-menu">
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-house-door"></i> Principal</a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-chat"></i> Chat</a></li>
            <li class="nav-item"><a href="#" class="nav-link active"><i class="bi bi-book"></i> Cursos</a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-award"></i> Certificados</a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-people"></i> Amigos</a></li>
        </ul>
        <div class="nav-divider"></div>
        <ul class="nav-menu">
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-question-circle"></i> Ajuda e FAQ</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Modo escuro <i class="bi bi-moon-stars ms-auto"></i></a></li>
        </ul>
    </div>

    <!-- 2. MAIN CONTENT (Área principal) -->
    <div class="main-content">

        <!-- 2.1. HEADER (Estrutura idêntica com correção da notificação) -->
        <div class="header">
            <div></div>
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

        <!-- 2.2. CONTEÚDO DA AULA (NOVA SEÇÃO ) -->
        <div class="lesson-area">
            <header class="lesson-header">
                <!-- Título do módulo será inserido aqui pelo JS -->
            </header>

            <div class="lesson-content-grid">
                <!-- Coluna da Esquerda: Vídeos -->
                <div class="video-section">
                    <h2>Vídeo Aula</h2>
                    <div id="video-list" class="video-grid">
                        <!-- Placeholders de vídeo serão inseridos aqui -->
                    </div>
                </div>

                <!-- Coluna da Direita: Materiais -->
                <div class="materials-section">
                    <h2>Material de Estudo</h2>
                    <div id="materials-list" class="materials-list">
                        <!-- Links de material serão inseridos aqui -->
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pop-up de Notificações (estrutura idêntica) -->
        <div class="notifications-popup" id="notifications-popup">
            <div class="popup-header"><h2>Notificações</h2></div>
            <div class="popup-tabs">
                <button class="tab-button active" data-tab="todas">Todas <span class="badge" id="todas-badge"></span></button>
                <button class="tab-button" data-tab="alertas">Alertas</button>
                <button class="tab-button" data-tab="noticias">Notícias</button>
            </div>
            <div class="popup-body" id="notification-list"></div>
        </div>

    </div>

    <!-- 3. SCRIPTS -->
    <script src="../Templates/js/pagina-modulo.js"></script>
    <script src="../Templates/js/notificacao.js"></script>

</body>
</html>
