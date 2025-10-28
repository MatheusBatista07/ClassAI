<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['cadastro_etapa1']) || !isset($_SESSION['cadastro_etapa2'])) {
    header('Location: paginaDeCadastro.php');
    exit;
}

require_once __DIR__ . '/../Controller/UserController.php';

$erro = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new Controller\UserController();
    
    $nome_usuario = $_POST['userName'] ?? '';
    $descricao = $_POST['userDescricao'] ?? '';
    $foto = $_FILES['userFoto'] ?? null;
    
    $erro = $controller->processarEtapa3($nome_usuario, $descricao, $foto);
    
    if ($erro === null) {
        header('Location: pagina-login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAi | Cadastro - Etapa Final</title>
    <link rel="stylesheet" href="../Templates/css/paginaPersonalizacao.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <header>
        <a href="index.php">
            <figure>
                <img src="../Images/Ícones do header/Logo ClassAi branca.png" alt="Logo ClassAi">
            </figure>
        </a>
    </header>

    <div class="container">
        <main>
            <div class="conteudo_principal">
                <form action="paginaPersonalizacao.php" method="POST" class="formulario" enctype="multipart/form-data">
                    <h1>Vamos deixar com a sua cara agora!</h1>
                    <h2>Seus dados estão protegidos!</h2>

                    <?php if ($erro ): ?>
                        <div style="color: red; background-color: #ffdddd; border: 1px solid red; padding: 10px; margin: 15px 0; border-radius: 5px; text-align: center;">
                            <?php echo htmlspecialchars($erro); ?>
                        </div>
                    <?php endif; ?>

                    <div class="form-layout">
                        <div class="top-row">
                            <div class="upload-container">
                                <input type="file" id="foto-perfil" name="userFoto" accept="image/*" capture="user" style="display: none;">
                                <label for="foto-perfil" class="upload-label">
                                    <i class="bi bi-plus"></i>
                                    <img id="imagePreview" src="#" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover; display: none;" />
                                </label>
                            </div>
                            <div class="field-wrapper">
                                <input type="text" name="userName" class="userName form-control" placeholder="Usuário" required>
                                <small class="msg-erro nome-erro" style="display:none; color:red;">Por favor, digite seu nome de usuário.</small>
                            </div>
                        </div>
                        <div class="bottom-row">
                            <textarea name="userDescricao" class="userDescription form-control" placeholder="Descrição"></textarea>
                        </div>
                    </div>

                    <div class="buttons">
                        <button class="entrar" type="submit" id="btnCadastrar">Finalizar</button>
                    </div>
                </form>

                <div class="lazzo">
                    <figure>
                        <img class="lazzoImg" src="../Images/Página de Login e Cadastro/LazzoPf.png" alt="Lazzo">
                    </figure>
                </div>
            </div>
        </main>
    </div>

    <script src="../Templates/js/paginaPersonalizacao.js"></script>
</body>
</html>
