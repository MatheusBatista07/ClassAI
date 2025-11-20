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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body>

    <header>
        <a href="../index.php">
            <figure>
                <img src="../Images/Icones-do-header/Logo-ClassAi-branca.png" alt="Logo ClassAi">
            </figure>
        </a>
    </header>

    <div class="container">
        <main>
            <div class="conteudo_principal">

                <form action="pagina-login.php" method="POST" class="formulario">
                    <h1 style="color: white">Bem vindo de volta!</h1>
                    <h2 style="color: white">O que vamos aprender hoje?</h2>

                    <?php if ($erro ): ?>
                        <div class="error-box-php">
                            <?php echo htmlspecialchars($erro); ?>
                        </div>
                    <?php endif; ?>

                    <div class="inputs">
                        <!-- ===== LINHA ALTERADA ===== -->
                        <input type="email" name="userEmail" class="userEmail form-control" placeholder="E-mail" required autocomplete="username">
                        
                        <label class="password-label">
                            <!-- ===== LINHA ALTERADA ===== -->
                            <input type="password" name="userPassword" id="userPassword" class="userPassword form-control" placeholder="Senha" required autocomplete="current-password">
                            <i class="bi bi-eye-slash" id="togglePassword"></i>
                        </label>

                        <div class="remember-forgot-container">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember_me" id="rememberMeCheck" value="1">
                                <label class="form-check-label" for="rememberMeCheck">
                                    Lembrar de mim
                                </label>
                            </div>
                            <a href="pagina-esqueci-senha.php" class="esqueceuSenha">Esqueceu a senha?</a>
                        </div>
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
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
    <script src="../Templates/js/globalPresence.js"></script>
</html>
