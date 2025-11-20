<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAI | Recuperar Senha</title>
    <link rel="stylesheet" href="../Templates/css/pagina-esqueci-senha.css">
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

                <form action="../Controller/solicitar-redefinicao.php" method="POST" class="formulario">
                    <h1 style="color: white">Recuperar Senha</h1>
                    <h2 style="color: white">Informe seu e-mail para continuar.</h2>

                    <?php if (isset($_GET['status'])): ?>
                        <?php if ($_GET['status'] === 'success'): ?>
                            <div class="success-box-php">
                                Se o e-mail estiver cadastrado, um link de recuperação foi enviado. Verifique sua caixa de entrada e spam.
                                  
<strong>Você será redirecionado em 5 segundos...</strong>
                            </div>
                        <?php elseif ($_GET['status'] === 'error'): ?>
                            <div class="error-box-php">
                                Ocorreu um erro. Tente novamente mais tarde.
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <div class="inputs">
                        <input type="email" name="userEmail" class="userEmail form-control" placeholder="Digite seu e-mail" required>
                    </div>

                    <div class="buttons">
                        <button type="submit" class="entrar">Enviar Link de Recuperação</button>
                    </div>
                    <p class="nao_tem_conta" style="color: #C37BFF">Lembrou a senha? <a class="cadastre_se" href="pagina-login.php" style="color: #C37BFF">Faça login</a></p>
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
            const urlParams = new URLSearchParams(window.location.search);
            
            if (urlParams.get('status') === 'success') {
                setTimeout(function() {
                    window.location.href = 'pagina-login.php';
                }, 5000);
            }
        });
    </script>

</body>
</html>
