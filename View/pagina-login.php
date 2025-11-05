<?php
session_start();
require_once __DIR__ . '/../Controller/UserController.php';
$erro = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new Controller\UserController();
    $email = $_POST['userEmail'] ?? '';
    $senha = $_POST['userPassword'] ?? '';
    $erro = $controller->processarLogin($email, $senha);
    if ($erro === null) {
        header('Location: PaginaHome.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAi | Login</title>
    <link rel="stylesheet" href="../Templates/css/pagina-login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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

                <form action="pagina-login.php" method="POST" class="formulario">
                    <h1 style="color: white">Bem vindo de volta!</h1>
                    <h2 style="color: white">O que vamos aprender hoje?</h2>

                    <?php if ($erro): ?>
                        <div class="error-box-php" style="color: red; background-color: #ffdddd; border: 1px solid red; padding: 10px; margin: 15px 0; border-radius: 5px; text-align: center; font-weight: bold;">
                            <?php echo htmlspecialchars($erro); ?>
                        </div>
                    <?php endif; ?>

                    <div class="inputs">
                        <input type="email" name="userEmail" class="userEmail form-control" placeholder="E-mail" required>
                        <label class="password-label">
                            <input type="password" name="userPassword" id="userPassword" class="userPassword form-control" placeholder="Senha" required>
                            <i class="bi bi-eye-slash" id="togglePassword"></i>
                        </label>

                        <p class="esqueceuSenha" style="color: #C37BFF">Esqueceu a senha?</p>
                    </div>

                    <div class="buttons">
                        <button type="submit" class="entrar">Entrar</button>
                    </div>
                    <p class="nao_tem_conta" style="color: #C37BFF">Não tem conta? <a class="cadastre_se" href="paginaDeCadastro.php" style="color: #C37BFF">Cadastre-se</a></p>
                </form>

                <div class="lazzo">
                    <figure>
                        <img class="lazzoImg" src="../Images/Login/LazzoTexto.png" alt="Lazzo">
                    </figure>
                </div>
            </div>
        </main>
    </div>
</body>
<script src="../Templates/js/MostrarSenha.js"></script>
<script src="../Templates/js/pagina-login.js"></script>
<script src="../Templates/js/globalPresence.js"></script>
</html>