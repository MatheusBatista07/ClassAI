<?php
session_start();

// Proteção: Se o usuário não estiver logado, redireciona para o login
if (!isset($_SESSION['usuario_id'])) {
    header('Location: pagina-login.php');
    exit;
}

// Inclui o ChatController
require_once __DIR__ . '/../Controller/ChatController.php';

// Pega o ID do usuário logado da sessão
$currentUserId = $_SESSION['usuario_id'];

// Cria uma instância do controller
$chatController = new \Controller\ChatController();

// CHAMA O MÉTODO PARA BUSCAR A LISTA DE CONTATOS (PROFESSORES)
$listaDeContatos = $chatController->getContactList($currentUserId);

?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAI - Chat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../Templates/css/paginaChat.css">
</head>
<!-- 1. Adicionamos o ID do usuário logado aqui para o JS poder pegar facilmente -->

<body data-user-id="<?php echo $currentUserId; ?>">

    <!-- Sidebar (sem alterações ) -->
    <div class="sidebar">
        <img src="../Images/Ícones do header/Logo ClassAI branca.png" alt="Imagem logo ClassAII" class="img-logo">
        <ul class="nav-menu">
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-house-door"></i> Principal</a></li>
            <li class="nav-item"><a href="#" class="nav-link active"><i class="bi bi-chat"></i> Chat</a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-book"></i> Cursos</a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-award"></i> Certificados</a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-people"></i> Amigos</a></li>
        </ul>
        <div class="nav-divider"></div>
        <ul class="nav-menu">
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-question-circle"></i> Ajuda e FAQ</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Modo escuro <i class="bi bi-moon-stars ms-auto"></i></a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <!-- Header (sem alterações) -->
        <div class="header">
            <div></div>
            <div class="header-icons">
                <div class="header-icon"><img src="../Images/Ícones do header/lazzo.png" alt="Imagem lazzo"
                        class="lazzo_img"></div>
                <div class="header-icon"><i class="bi bi-bell"></i></div>
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
        </div>

        <!-- Container principal do chat -->
        <div class="chat-wrapper">

            <!-- VISUALIZAÇÃO 1: LISTA DE CONTATOS -->
            <div id="contacts-view" class="chat-container">
                <div class="chat-header">
                    <div class="d-flex align-items-center">
                        <i class="bi bi-chat-left-text-fill me-3" style="font-size: 1.4rem;"></i>
                        <div>
                            <h1 class="h4 mb-0">Página de Chat</h1>
                            <p class="text-muted mb-0">Suas conversas recentes</p>
                        </div>
                    </div>
                </div>
                <div class="chat-list">
                    <!-- NOTA: IDs dos contatos ajustados para simular uma conversa com o usuário 1 -->
                    <div class="chat-item" data-contact-id="2" data-contact-name="Professor João"
                        data-contact-avatar="https://via.placeholder.com/50/FFC300">
                        <img src="../Images/Página de Apresentação/Lazo.png" alt="Avatar" class="chat-avatar">
                        <div class="chat-info">
                            <div class="chat-name">Professor João</div>
                            <div class="chat-message">Clique para ver a conversa...</div>
                        </div>
                        <div class="chat-time"></div>
                    </div>
                    <div class="chat-item" data-contact-id="3" data-contact-name="Professor Cleber"
                        data-contact-avatar="../Images/Página de Apresentação/Lazo.png">
                        <img src="../Images/Página de Apresentação/Lazo.png" alt="Avatar" class="chat-avatar">
                        <div class="chat-info">
                            <div class="chat-name">Professor Cleber</div>
                            <div class="chat-message">Clique para ver a conversa...</div>
                        </div>
                        <div class="chat-time"></div>
                    </div>
                </div>
            </div>

            <!-- VISUALIZAÇÃO 2: JANELA DE CONVERSA (Oculta ) -->
            <div id="conversation-view" class="chat-container" style="display: none;">
                <div class="conversation-header">
                    <button id="back-to-contacts" class="btn btn-icon"><i class="bi bi-arrow-left"></i></button>
                    <img id="conversation-avatar" src="" alt="Avatar" class="chat-avatar">
                    <div class="conversation-info">
                        <div id="conversation-name" class="chat-name"></div>
                        <div id="conversation-status" class="chat-status">Online</div>
                    </div>
                    <div class="ms-auto">
                        <button class="btn btn-icon"></i></button>
                    </div>
                </div>

                <!-- 2. Corpo das Mensagens agora está vazio, pronto para ser preenchido pela API -->
                <div id="message-list" class="message-list">
                    <!-- As mensagens serão inseridas aqui dinamicamente pelo JavaScript -->
                </div>

                <!-- Input de Envio de Mensagem (sem alterações) -->
                <div class="message-input-area">
                    <input type="text" id="message-input" class="form-control" placeholder="Digite uma mensagem...">
                    <button id="send-message-btn" class="btn btn-send"><i class="bi bi-send-fill"></i></button>
                </div>
            </div>

        </div> <!-- Fim do .chat-wrapper -->
    </div> <!-- Fim do .main-content -->

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- 3. ADICIONADO O SCRIPT DO PUSHER (essencial para tempo real ) -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

    <!-- Seu script do chat, que agora pode usar o Pusher -->
    <script src="../Templates/js/paginaChat.js"></script>
</body>

</html>