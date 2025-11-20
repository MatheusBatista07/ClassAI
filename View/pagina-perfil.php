<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../Model/UserModel.php';

$userModel = new \Model\UserModel();
$usuario = $userModel->encontrarUsuarioPorId($_SESSION['usuario_id']);

if (!$usuario) {
    header('Location: /ClassAI/View/pagina-login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - ClassAI</title>
    <link rel="stylesheet" href="/ClassAI/Templates/css/pagina-perfil.css">
</head>
<body>

    <?php require_once __DIR__ . '/_sidebar.php'; ?>

    <div class="main-content">
    
        <?php require_once __DIR__ . '/_header.php'; ?>

        <main class="container-perfil">
            <h1 class="perfil-main-title">Meu Perfil</h1>
            
            <div id="form-feedback" class="alert" style="display: none;"></div>

            <form id="form-editar-perfil" class="perfil-card">
                <div class="perfil-body">
                    <div class="info-grupo">
                        <label>Foto de Perfil</label>
                        <div class="foto-container">
                            <img src="<?php echo '/ClassAI/' . htmlspecialchars($usuario['foto_perfil_url'] ?? 'Images/perfil_padrao.png'); ?>" alt="Foto de Perfil" class="foto-perfil">
                        </div>
                    </div>

                    <div class="info-grupo">
                        <label for="nome">Nome Completo</label>
                        <span class="view-mode"><?php echo htmlspecialchars($usuario['nome'] . ' ' . $usuario['sobrenome']); ?></span>
                        <div class="edit-mode" style="display: none;">
                            <input type="text" id="nome" name="nome" class="form-control-perfil" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>
                            <input type="text" id="sobrenome" name="sobrenome" class="form-control-perfil mt-2" value="<?php echo htmlspecialchars($usuario['sobrenome']); ?>" required>
                        </div>
                    </div>

                    <div class="info-grupo">
                        <label>Email</label>
                        <span><?php echo htmlspecialchars($usuario['email']); ?></span>
                    </div>

                    <div class="info-grupo">
                        <label>Função</label>
                        <span class="funcao-tag"><?php echo htmlspecialchars(ucfirst($usuario['funcao'])); ?></span>
                    </div>

                    <div class="perfil-actions">
                        <button type="button" id="btn-editar" class="btn-editar view-mode">Editar Perfil</button>
                        <button type="submit" id="btn-salvar" class="btn-editar edit-mode" style="display: none;">Salvar Alterações</button>
                        <button type="button" id="btn-cancelar" class="btn-cancelar edit-mode" style="display: none;">Cancelar</button>
                    </div>
                </div>
            </form>
        </main>
    </div>

    <script src="/ClassAI/Templates/js/editar-perfil.js"></script>
</body>
</html>
