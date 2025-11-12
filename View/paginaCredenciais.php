<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

if (!isset($_SESSION['cadastro_etapa1'])) {
    header('Location: paginaDeCadastro.php');
    exit;
}

require_once __DIR__ . '/../Controller/UserController.php';

$erro = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new Controller\UserController();

    $nome = $_POST['userName'] ?? '';
    $sobrenome = $_POST['userSobrenome'] ?? '';
    $formacao = $_POST['formacao'] ?? '';
    $cpf = $_POST['userCPF'] ?? '';

    $erro = $controller->processarEtapa2($nome, $sobrenome, $formacao,$cpf);

    if ($erro === null) {
        header('Location: paginaPersonalizacao.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAi | Cadastro - Etapa 2</title>
    <link rel="stylesheet" href="../Templates/css/paginaCredenciais.css">
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
                <form action="paginaCredenciais.php" method="POST" class="formulario">
                    <h1 style="color: white">Estamos quase lá!</h1>
                    <h2 style="color: white">Nos diga um pouco mais sobre você.</h2>

                    <?php if ($erro): ?>
                        <div style="color: red; background-color: #ffdddd; border: 1px solid red; padding: 10px; margin-bottom: 15px; border-radius: 5px; text-align: center;">
                            <?php echo htmlspecialchars($erro); ?>
                        </div>
                    <?php endif; ?>

                    <div class="inputs">
                        <input type="text" name="userName" class="form-control" placeholder="Nome" required>
                        <input type="text" name="userSobrenome" class="form-control" placeholder="Sobrenome" required>
                        <input type="text" name="formacao" class="form-control" placeholder="Formação profissional" required>

                        <input type="text" name="userCPF" class="form-control" placeholder="CPF" required>
                        <small style="color: #ccc; font-size: 0.8em;">Seu CPF é armazenado com segurança e criptografado.</small>

                        <div class="buttons">
                            <button type="submit" class="entrar btn btn-primary">Avançar</button>
                        </div>
                    </div>
                </form>

                <div class="lazzo">
                    <figure>
                        <img class="lazzoImg" src="../Images/Login/LazzoCadastro.png" alt="Lazzo">
                    </figure>
                </div>
            </div>
        </main>
    </div>
    <script src="../Templates/js/paginaCredenciais.js"></script>
</body>

</html>
