<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../Model/ChatModel.php';
require_once __DIR__ . '/../Model/UserModel.php';
require_once __DIR__ . '/../Model/NotificationModel.php';
require_once __DIR__ . '/../Model/AmigosModel.php';

require_once __DIR__ . '/../Controller/ChatController.php';

$currentUserId = $_SESSION['usuario_id'];
$initialContactId = $_GET['contactId'] ?? 'null';

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
</head>
<body data-user-id="<?php echo $currentUserId; ?>" data-initial-contact-id="<?php echo $initialContactId; ?>" data-active-contact-id="">

    <?php require_once __DIR__ . '/_sidebar.php'; ?>

    <div class="main-content">
        
        <?php require_once __DIR__ . '/_header.php'; ?>

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
                        <div class="text-center text-muted p-4" style="padding-top: 50px !important;">
                            <i class="bi bi-people" style="font-size: 3rem; color: #581c87;"></i>
                            <h5 class="mt-3">Sua lista de contatos está vazia</h5>
                            <p class="mb-0 mt-2">Para conversar com alguém, você precisa ter uma conexão.</p>
                            <p>Vá para a página de <a href="pagina-amigos.php" style="color: #C37BFF; font-weight: bold;">Amigos</a> para encontrar novas pessoas!</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($listaDeContatos as $contato):
                            $avatarUrl = !empty($contato['foto_perfil_url']) ? "/ClassAI/" . htmlspecialchars($contato['foto_perfil_url']) : 'https://ui-avatars.com/api/?name=' . urlencode($contato['nome'] ) . '&background=random';
                        ?>
                            <div class="chat-item" data-contact-id="<?php echo $contato['id']; ?>" data-contact-name="<?php echo htmlspecialchars($contato['nome'] . ' ' . $contato['sobrenome']); ?>" data-contact-avatar="<?php echo $avatarUrl; ?>" data-contact-status="<?php echo htmlspecialchars($contato['status'] ?? 'offline'); ?>">
                                <div class="chat-avatar-container">
                                    <img src="<?php echo $avatarUrl; ?>" alt="Avatar de <?php echo htmlspecialchars($contato['nome']); ?>" class="chat-avatar">
                                    <div id="status-indicator-<?php echo $contato['id']; ?>" class="status-indicator"></div>
                                </div>
                                <div class="chat-info">
                                    <div class="chat-name"><?php echo htmlspecialchars($contato['nome'] . ' ' . $contato['sobrenome']); ?></div>
                                    <div class="chat-message">
                                        <?php
                                        if (!empty($contato['ultima_mensagem'])) {
                                            $mensagem = htmlspecialchars($contato['ultima_mensagem']);
                                            echo mb_strlen($mensagem) > 25 ? mb_substr($mensagem, 0, 25) . '...' : $mensagem;
                                        } else {
                                            echo 'Clique para iniciar a conversa...';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="chat-meta">
                                    <?php if (!empty($contato['unread_count']) && $contato['unread_count'] > 0): ?>
                                        <span class="unread-count">
                                            <?php echo $contato['unread_count'] > 99 ? '99+' : $contato['unread_count']; ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
            <div id="conversation-view" class="chat-container" style="display: none;">
                <div class="conversation-header">
                    <button id="back-to-contacts" class="btn btn-icon"><i class="bi bi-arrow-left"></i></button>
                    <img id="conversation-avatar" src="" alt="Avatar" class="chat-avatar">
                    <div class="conversation-info">
                        <div id="conversation-name" class="chat-name"></div>
                        <div id="conversation-status" class="chat-status"></div>
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

    <script src="/ClassAI/Templates/js/paginaChat.js"></script>

</body>
</html>
