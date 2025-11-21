<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Model/ChatModel.php';
require_once __DIR__ . '/../Model/UserModel.php';
require_once __DIR__ . '/../Controller/ChatController.php';

$currentUserId = $_SESSION['usuario_id'];
$initialContactId = $_GET['contactId'] ?? 'null';

$userModel = new \Model\UserModel();
$usuarioLogado = $userModel->encontrarUsuarioPorId($currentUserId);

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

<body data-user-id="<?php echo $currentUserId; ?>" data-initial-contact-id="<?php echo $initialContactId; ?>" data-active-contact-id="">

    <div class="sidebar">
        <img src="/ClassAI/Images/Icones-do-header/Logo-ClassAI-branca.png" alt="Imagem logo ClassAII" class="img-logo">
        <ul class="nav-menu">
            <li class="nav-item"><a href="PaginaHome.php" class="nav-link"><i class="bi bi-house-door"></i> Principal</a></li>
            <li class="nav-item"><a href="paginaChat.php" class="nav-link active"><i class="bi bi-chat"></i> Chat</a></li>
            <li class="nav-item"><a href="PaginaPrincipalCursos.php" class="nav-link"><i class="bi bi-book"></i> Cursos</a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-award"></i> Certificados</a></li>
            <li class="nav-item"><a href="pagina-amigos.php" class="nav-link"><i class="bi bi-people"></i> Amigos</a></li>
        </ul>
        <div class="nav-divider"></div>
        <ul class="nav-menu">
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-question-circle"></i> Ajuda e FAQ</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Modo escuro <i class="bi bi-moon-stars ms-auto"></i></a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <div></div>
            <div class="header-icons">
                <div class="header-icon"><img src="/ClassAI/Images/Icones-do-header/lazzo.png" alt="Imagem lazzo" class="lazzo_img"></div>
                <div class="header-icon"><i class="bi bi-bell"></i></div>
                
                <!-- ===================================================================== -->
                <!-- CORREÇÃO: Removido o link <a> e adicionado o ID para o JavaScript -->
                <!-- ===================================================================== -->
                <div class="user-profile" id="user-profile-icon">
                    <?php
                    $avatarUsuarioLogado = !empty($usuarioLogado['foto_perfil_url'] )
                        ? '/ClassAI/' . htmlspecialchars($usuarioLogado['foto_perfil_url'])
                        : 'https://ui-avatars.com/api/?name=' . urlencode($usuarioLogado['nome'] ) . '&background=random';
                    ?>
                    <img src="<?php echo $avatarUsuarioLogado; ?>"
                        alt="Avatar de <?php echo htmlspecialchars($usuarioLogado['nome']); ?>"
                        class="user-avatar">
                    <img src="/ClassAI/Images/Icones-do-header/setinha-perfil.png" alt="Seta" class="arrow-icon">
                </div>
            </div>
            <div class="header_mobile">
                <img src="/ClassAI/Images/Icones-do-header/Logo ClassAI branca.png" alt="Imagem logo ClassAII" class="img-logo">
                <i class="bi bi-list"></i>
            </div>
        </div>

        <!-- ===================================================================== -->
        <!-- ADIÇÃO: Incluindo o popup do perfil aqui -->
        <!-- ===================================================================== -->
        <?php require_once __DIR__ . '/_popupPerfil.php'; ?>

        <div class="chat-wrapper">
            <!-- ... (o resto do seu HTML do chat continua igual) ... -->
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
                    <?php if (empty($listaDeContatos)): ?>
                        <div class="text-center text-muted p-4" style="padding-top: 50px !important;">
                            <i class="bi bi-people" style="font-size: 3rem; color: #581c87;"></i>
                            <h5 class="mt-3">Sua lista de contatos está vazia</h5>
                            <p class="mb-0 mt-2">Para conversar com alguém, você precisa ter uma conexão.</p>
                            <p>Vá para a página de <a href="pagina-amigos.php#encontrar" style="color: #C37BFF; font-weight: bold;">Amigos</a> para encontrar novas pessoas!</p>
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
                                data-contact-avatar="<?php echo $avatarUrl; ?>"
                                data-contact-status="<?php echo htmlspecialchars($contato['status'] ?? 'offline'); ?>">

                                <div class="chat-avatar-container">
                                    <img src="<?php echo $avatarUrl; ?>"
                                        alt="Avatar de <?php echo htmlspecialchars($contato['nome']); ?>" class="chat-avatar">
                                    <div id="status-indicator-<?php echo $contato['id']; ?>" class="status-indicator"></div>
                                </div>

                                <div class="chat-info">
                                    <div class="chat-name"><?php echo htmlspecialchars($contato['nome'] . ' ' . $contato['sobrenome']); ?></div>
                                    <div class="chat-message">
                                        <?php
                                        if (!empty($contato['ultima_mensagem'])) {
                                            $mensagem = htmlspecialchars($contato['ultima_mensagem']);
                                            echo mb_strlen($mensagem) > 30 ? mb_substr($mensagem, 0, 30) . '...' : $mensagem;
                                        } else {
                                            echo 'Clique para iniciar a conversa...';
                                        }
                                        ?>
                                    </div>
                                </div>
                                <div class="chat-meta">
                                    <div class="chat-time">
                                        <?php
                                        if (!empty($contato['timestamp_ultima_mensagem'])) {
                                            try {
                                                $date = new DateTime($contato['timestamp_ultima_mensagem']);
                                                echo $date->format('H:i');
                                            } catch (Exception $e) {
                                            }
                                        }
                                        ?>
                                    </div>
                                    <span class="unread-count" style="display: none;">0</span>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="../Templates/js/globalPresence_v2.js"></script>
    <script src="/ClassAI/Templates/js/paginaChat.js"></script>

    <!-- ===================================================================== -->
    <!-- ADIÇÃO: JavaScript para controlar o popup do perfil nesta página -->
    <!-- ===================================================================== -->
    <script>
    document.addEventListener('DOMContentLoaded', function( ) {
        const profileIcon = document.getElementById('user-profile-icon');
        const profilePopup = document.getElementById('profile-popup');

        if (profileIcon && profilePopup) {
            profileIcon.addEventListener('click', function(event) {
                event.stopPropagation();
                profilePopup.classList.toggle('show');
            });

            window.addEventListener('click', function(event) {
                if (profilePopup && !profilePopup.contains(event.target) && !profileIcon.contains(event.target)) {
                    profilePopup.classList.remove('show');
                }
            });
        }
    });
    </script>
</body>
</html>
