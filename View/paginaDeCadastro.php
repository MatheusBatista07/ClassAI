<?php
session_start();
require_once __DIR__ . '/../Controller/UserController.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
$erro = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new Controller\UserController();
    $email = $_POST['userEmail'] ?? '';
    $senha = $_POST['userPassword'] ?? '';
    $confirmaSenha = $_POST['userPasswordConfirm'] ?? '';
    $termos = isset($_POST['termosCheck']);
    $erro = $controller->processarEtapa1($email, $senha, $confirmaSenha, $termos);
    if ($erro === null) {
        header('Location: paginaCredenciais.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAi | Cadastro - Etapa 1</title>
    <link rel="stylesheet" href="../Templates/css/paginaDeCadastro.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <header>
        <a href="../index.php">
            <figure><img src="../Images/Icones-do-header/Logo-ClassAi-branca.png" alt="Logo ClassAi"></figure>
        </a>
    </header>

    <div class="container">
        <main>
            <div class="conteudo_principal">
                <form action="paginaDeCadastro.php" method="POST" class="formulario">
                    <h1 style="color: white">Que bom ver você!</h1>
                    <h2 style="color: white">O seu futuro começa aqui!</h2>

                    <?php if ($erro  ): ?>
                        <div style="color: red; background-color: #ffdddd; border: 1px solid red; padding: 10px; margin-bottom: 15px; border-radius: 5px; text-align: center;">
                            <?php echo htmlspecialchars($erro); ?>
                        </div>
                    <?php endif; ?>

                    <div class="inputs">
                        <input type="email" name="userEmail" class="userEmail form-control" placeholder="E-mail" required>

                        <label class="password-label">
                            <input type="password" name="userPassword" id="userPassword" class="userPassword form-control" placeholder="Senha"  minlength="6" required>
                            <i class="bi bi-eye-slash" id="togglePassword"></i>
                        </label>

                        <label class="password-label">
                            <input type="password" name="userPasswordConfirm" id="userPasswordConfirm" class="userPasswordConfirm form-control"  minlength="6" placeholder="Confirmar senha" required>
                            <i class="bi bi-eye-slash" id="togglePasswordConfirm"></i>
                        </label>
                        
                        <div class="form-check" style="color: #C37BFF; margin-top: 10px;">
                            <input class="form-check-input" type="checkbox" id="termosCheck" name="termosCheck" required>
                            <label class="form-check-label" for="termosCheck">
                                Li e estou de acordo com os 
                                <a href="#" style="color: #C37BFF; text-decoration: underline;">Termos de Uso</a>
                                e
                                <a href="#" style="color: #C37BFF; text-decoration: underline;">Política de Privacidade</a>
                            </label>
                        </div>

                        <div class="buttons">
                            <button type="submit" id="btnCadastrar" class="entrar btn btn-primary">Avançar</button>
                        </div>
                    </div>

                    <p class="nao_tem_conta" style="color: #C37BFF">Já tem conta? <a class="cadastre_se" href="pagina-login.php" style="color: #C37BFF">Entrar</a></p>
                </form>

                <div class="lazzo">
                    <figure><img class="lazzoImg" src="../Images/Login/LazzoCadastro.png" alt="Lazzo"></figure>
                </div>
            </div>
        </main>
    </div>
    <script src="../Templates/js/paginaDeCadastro.js"></script> 
    <script src="../Templates/js/MostrarSenha.js"></script>
    
</body>
</html>
