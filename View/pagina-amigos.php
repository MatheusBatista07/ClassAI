<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../Model/UserModel.php';

$userModel = new \Model\UserModel();
$userId = $_SESSION['usuario_id'];

$seguindo = $userModel->getSeguindo($userId);
$seguidores = $userModel->getSeguidores($userId);

$seguindoIds = array_column($seguindo, 'id');
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Amigos - ClassAI</title>
    <link rel="stylesheet" href="/ClassAI/Templates/css/pagina-amigos.css">
</head>
<body>

    <?php require_once __DIR__ . '/_sidebar.php'; ?>

    <div class="main-content">
    
        <?php require_once __DIR__ . '/_header.php'; ?>

        <main class="container-amigos">
            <h1 class="amigos-main-title">Amigos</h1>

            <div class="amigos-card">
                <div class="amigos-nav">
                    <button class="tab-link active" data-tab="seguindo">Seguindo</button>
                    <button class="tab-link" data-tab="seguidores">Seguidores</button>
                    <button class="tab-link" data-tab="encontrar">Encontrar Amigos</button>
                </div>

                <div class="tab-content active" id="seguindo">
                    <?php if (empty($seguindo)): ?>
                        <p class="empty-tab-message">Você ainda não segue ninguém.</p>
                    <?php else: ?>
                        <?php foreach ($seguindo as $usuario): ?>
                            <div class="user-item">
                                <a href="pagina-perfil.php?id=<?php echo $usuario['id']; ?>" class="user-link">
                                    <img src="<?php echo '/ClassAI/' . htmlspecialchars($usuario['foto_perfil_url'] ?? 'Images/perfil_padrao.png'); ?>" alt="Foto de <?php echo htmlspecialchars($usuario['nome']); ?>">
                                    <span><?php echo htmlspecialchars($usuario['nome'] . ' ' . $usuario['sobrenome']); ?></span>
                                </a>
                                <button class="btn-amigos btn-unfollow" data-userid="<?php echo $usuario['id']; ?>">Deixar de Seguir</button>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="tab-content" id="seguidores">
                     <?php if (empty($seguidores)): ?>
                        <p class="empty-tab-message">Você ainda não tem seguidores.</p>
                    <?php else: ?>
                        <?php foreach ($seguidores as $usuario): ?>
                            <div class="user-item">
                                <a href="pagina-perfil.php?id=<?php echo $usuario['id']; ?>" class="user-link">
                                    <img src="<?php echo '/ClassAI/' . htmlspecialchars($usuario['foto_perfil_url'] ?? 'Images/perfil_padrao.png'); ?>" alt="Foto de <?php echo htmlspecialchars($usuario['nome']); ?>">
                                    <span><?php echo htmlspecialchars($usuario['nome'] . ' ' . $usuario['sobrenome']); ?></span>
                                </a>
                                <?php if (in_array($usuario['id'], $seguindoIds)): ?>
                                    <button class="btn-amigos btn-following" disabled>Seguindo</button>
                                <?php else: ?>
                                    <button class="btn-amigos btn-follow" data-userid="<?php echo $usuario['id']; ?>">Seguir de Volta</button>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div class="tab-content" id="encontrar">
                    <div class="search-container">
                        <input type="text" id="search-input" placeholder="Digite um nome para buscar...">
                    </div>
                    <div id="search-results">
                        <p class="empty-tab-message">Comece a digitar para encontrar novos amigos.</p>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="/ClassAI/Templates/js/pagina-amigos.js"></script>
    
    <!-- SCRIPTS GLOBAIS REMOVIDOS DAQUI -->

</body>
</html>
