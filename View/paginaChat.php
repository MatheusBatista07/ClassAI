<?php
// View/paginaChat.php

session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: pagina-login.php');
    exit;
}

// Carrega o autoloader do Composer (para o Pusher) e as nossas classes.
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Model/UserModel.php';
require_once __DIR__ . '/../Model/ChatModel.php';
require_once __DIR__ . '/../Controller/ChatController.php';

$currentUserId = $_SESSION['usuario_id'];

$chatController = new \Controller\ChatController();
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
    <link rel="stylesheet" href="/ClassAI/Templates/css/paginaChat.css">
</head>

<body data-user-id="<?php echo $currentUserId; ?>">

    <!-- Sidebar -->
    <div class="sidebar">
        <img src="/ClassAI/Images/Ícones do header/Logo ClassAI branca.png" alt="Imagem logo ClassAII" class="img-logo">
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
            <li class="nav-item"><a href="#" class="nav-link">Modo escuro <i class="bi bi-moon-stars ms-auto"></i></a></li>
        </ul>
    </div>

    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div></div>
            <div class="header-icons">
                <div class="header-icon"><img src="/ClassAI/Images/Ícones do header/lazzo.png" alt="Imagem lazzo" class="lazzo_img"></div>
                <div class="header-icon"><i class="bi bi-bell"></i></div>
                <div class="user-profile">
                    <img src="https://via.placeholder.com/40" alt="Avatar do Usuário" class="user-avatar">
                    <img src="/ClassAI/Images/Ícones do header/setinha perfil.png" alt="Seta" class="arrow-icon">
                </div>
            </div>
            <div class="header_mobile">
                <img src="/ClassAI/Images/Ícones do header/Logo ClassAI branca.png" alt="Imagem logo ClassAII" class="img-logo">
                <i class="bi bi-list"></i>
            </div>
        </div>

        <!-- Container principal do chat -->
        <div class="chat-wrapper">
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
                    <?php if (empty($listaDeContatos )): ?>
                        <div class="text-center text-muted p-4">
                            <strong>Nenhum outro usuário encontrado.</strong>
                        </div>
                    <?php else: ?>
                        <?php foreach ($listaDeContatos as $contato): 
                            $avatarUrl = !empty($contato['foto_perfil_url']) 
                                ? "/ClassAI/" . htmlspecialchars($contato['foto_perfil_url']) 
                                : 'https://ui-avatars.com/api/?name=' . urlencode($contato['nome'] ) . '&background=random';
                        ?>
                            <div class="chat-item" 
                                 data-contact-id="<?php echo $contato['id']; ?>" 
                                 data-contact-name="<?php echo htmlspecialchars($contato['nome'] . ' ' . $contato['sobrenome']); ?>"
                                 data-contact-avatar="<?php echo $avatarUrl; ?>">
                                
                                <img src="<?php echo $avatarUrl; ?>" 
                                     alt="Avatar de <?php echo htmlspecialchars($contato['nome']); ?>" class="chat-avatar">
                                
                                <div class="chat-info">
                                    <div class="chat-name"><?php echo htmlspecialchars($contato['nome'] . ' ' . $contato['sobrenome']); ?></div>
                                    <div class="chat-message">Clique para iniciar a conversa...</div>
                                </div>
                                <div class="chat-time"></div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Janela de Conversa (Oculta) -->
            <div id="conversation-view" class="chat-container" style="display: none;">
                <div class="conversation-header">
                    <button id="back-to-contacts" class="btn btn-icon"><i class="bi bi-arrow-left"></i></button>
                    <img id="conversation-avatar" src="" alt="Avatar" class="chat-avatar">
                    <div class="conversation-info">
                        <div id="conversation-name" class="chat-name"></div>
                        <div id="conversation-status" class="chat-status">Online</div>
                    </div>
                    <div class="ms-auto"><button class="btn btn-icon"></button></div>
                </div>
                <div id="message-list" class="message-list"></div>
                <div class="message-input-area">
                    <input type="text" id="message-input" class="form-control" placeholder="Digite uma mensagem...">
                    <button id="send-message-btn" class="btn btn-send"><i class="bi bi-send-fill"></i></button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <!-- O caminho absoluto para o JS também é uma boa prática -->
    <script src="/ClassAI/Templates/js/paginaChat.js"></script>
</body>
</html>

