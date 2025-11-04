<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAI | (Nome do curso)</title>
    <!-- Mesmos links de CSS e fontes da página anterior -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Link para um NOVO arquivo CSS específico para esta página -->
    <link rel="stylesheet" href="../Templates/css/pagina-modulos.css">
    <link rel="stylesheet" href="../Templates/css/notificacao.css">
</head>
<body>

    <!-- 1. SIDEBAR (Barra Lateral - Idêntica à anterior ) -->
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

    <!-- 2. MAIN CONTENT (TODA a área principal da página) -->
    <div class="main-content">

        <!-- 2.1. HEADER (Cabeçalho - Idêntico ao anterior) -->
       <!-- 2.1. HEADER (Cabeçalho - ESTRUTURA CORRIGIDA E REUTILIZÁVEL) -->
<div class="header">
    <div></div> <!-- Elemento para alinhamento -->
    <div class="header-icons">
        <div class="header-icon"><img src="../Images/Ícones do header/lazzo.png" alt="Ícone Lazzo" class="lazzo_img"></div>
        
        <!-- INÍCIO DA SEÇÃO DE NOTIFICAÇÃO CORRIGIDA -->
        <div class="header-icon notification-icon-container">
            <i class="bi bi-bell" id="notification-bell"></i> <!-- 1. ID adicionado ao sino -->
            <div class="notification-dot" id="notification-dot"></div> <!-- 2. Elemento da bolinha adicionado -->
        </div>
        <!-- FIM DA SEÇÃO DE NOTIFICAÇÃO -->

        <div class="user-profile">
            <img src="https://via.placeholder.com/40" alt="Avatar do Usuário" class="user-avatar">
            <img src="../Images/Ícones do header/setinha perfil.png" alt="Seta" class="arrow-icon">
        </div>
    </div>
</div>

<!-- HEADER MOBILE❗ -->
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
<!-- FIM DO HEADER MOBILE -->


        <!-- 2.2. CONTEÚDO DOS MÓDULOS (NOVA SEÇÃO ) -->
        <div class="course-content-area">
            <header class="course-header">
                <h1>Chat GPT no dia a dia: Automatize tarefas com texto</h1>
                <h2>Módulos</h2>
            </header>

            <section id="modules-grid" class="modules-grid-container">
                <!-- Os cards dos módulos serão inseridos aqui pelo JavaScript -->
            </section>
        </div>

                <div class="notifications-popup" id="notifications-popup">
            <div class="popup-header"><h2>Notificações</h2></div>
            <div class="popup-tabs">
                <button class="tab-button active" data-tab="todas">Todas <span class="badge" id="todas-badge"></span></button>
            </div>
            <div class="popup-body" id="notification-list"></div>
        </div>

    </div>

    <!-- 3. SCRIPTS -->
    <!-- Link para um NOVO arquivo JS específico para esta página -->
    <script src="../Templates/js/pagina-modulos.js"></script>
    <script src="../Templates/js/notificacao.js"></script>

</body>
</html>
