<?php
$token = $_GET['token'] ?? null;
$error = $_GET['error'] ?? null;

$mensagem_erro = '';
if ($error) {
    switch ($error) {
        case 'campos_vazios':
            $mensagem_erro = 'Por favor, preencha todos os campos.';
            break;
        case 'senhas_diferentes':
            $mensagem_erro = 'As senhas não coincidem. Tente novamente.';
            break;
        case 'token_invalido':
            $mensagem_erro = 'Link de redefinição inválido ou expirado. Por favor, solicite um novo.';
            break;
        case 'senha_curta':
            $mensagem_erro = 'A senha deve ter no mínimo 6 caracteres.';
            break;
        default:
            $mensagem_erro = 'Ocorreu um erro inesperado. Tente novamente mais tarde.';
            break;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAI | Redefinir Senha</title>
    <link rel="stylesheet" href="../Templates/css/pagina-login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body>

    <header>
        <a href="pagina-login.php">
            <figure>
                <img src="../Images/Icones-do-header/Logo-ClassAi-branca.png" alt="Logo ClassAi">
            </figure>
        </a>
    </header>

    <div class="container">
        <main>
            <div class="conteudo_principal">

                <form action="../Controller/processar-redefinicao.php" method="POST" class="formulario">
                    <h1 style="color: white">Crie sua Nova Senha</h1>
                    <h2 style="color: white">Escolha uma senha forte e segura.</h2>

                    <?php if ($mensagem_erro ): ?>
                        <div class="error-box-php" style="color: white; background-color: #5c1a1a; border: 1px solid #ff4d4d; padding: 10px; margin: 15px 0; border-radius: 5px; text-align: center; font-weight: bold;">
                            <?php echo htmlspecialchars($mensagem_erro); ?>
                        </div>
                    <?php endif; ?>

                    <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

                    <div class="inputs">
                        <label class="password-label">
                            <input type="password" name="nova_senha" id="nova_senha" class="userPassword form-control" placeholder="Nova Senha" required minlength="6" title="A senha deve ter no mínimo 6 caracteres.">
                            <i class="bi bi-eye-slash" id="togglePassword1"></i>
                        </label>
                        <label class="password-label">
                            <input type="password" name="confirmar_senha" id="confirmar_senha" class="userPassword form-control" placeholder="Confirme a Nova Senha" required minlength="6">
                            <i class="bi bi-eye-slash" id="togglePassword2"></i>
                        </label>
                    </div>

                    <div class="buttons">
                        <button type="submit" class="entrar">Salvar Nova Senha</button>
                    </div>
                </form>

                <div class="lazzo">
                    <figure>
                        <img class="lazzoImg" src="../Images/Login/LazzoTexto.png" alt="Lazzo">
                    </figure>
                </div>
            </div>
        </main>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function setupToggle(toggleId, passwordId) {
                const toggle = document.getElementById(toggleId);
                const password = document.getElementById(passwordId);
                if (toggle && password) {
                    toggle.addEventListener('click', function() {
                        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                        password.setAttribute('type', type);
                        this.classList.toggle('bi-eye');
                        this.classList.toggle('bi-eye-slash');
                    });
                }
            }
            setupToggle('togglePassword1', 'nova_senha');
            setupToggle('togglePassword2', 'confirmar_senha');
        });
    </script>

</body>
</html>
