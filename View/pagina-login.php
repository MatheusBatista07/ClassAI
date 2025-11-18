<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAi | Login</title>
    <link rel="stylesheet" href="../Templates/css/pagina-login.css">
</head>
<body>
    
    <header>
        <a href="" class="logo">
            <figure>
                <img src="../Images/Ícones do header/Logo ClassAi branca.png" alt="Logo ClassAi">
            </figure>
        </a>
    </header>
<div class="container">
        <main>
        <div class="conteudo_principal">
        <form action="" class="formulario" style="display: block; justify-content: center; align-items: center"">
            <h1 style="color: white">Bem vindo de volta!</h1>
            <h2 style="color: white">O que vamos aprender hoje?</h2>
            
            <div class="inputs">
            <input type="text" name="userEmail" class="userEmail" placeholder="E-mail" required>
            
            <input type="text" name="userPassword" class="userPassword" placeholder="Senha" required>
            <p class="esqueceuSenha" style="color: #C37BFF">Esqueceu a senha?</p>
            </div>

            <div class="buttons">
                <button class="entrar">Entrar</button>
            </div>
            <p class="nao_tem_conta" style="color: #C37BFF">Não tem conta? <a class="cadastre_se" href="" style="color: #C37BFF">Cadastre-se</a></p>
        </form>

        <div class="lazzo">
             
            <figure style="display: flex; justify-content: space-between">
                <div class="buttons">
                <button class="entrar_tablet">Entrar</button>
                <p class="nao_tem_conta_tablet" style="color: #C37BFF">Não tem conta? <a class="cadastre_se_tablet" href="" style="color: #C37BFF">Cadastre-se</a></p>
            </div>
            
                <img class="lazzoImg" src="../Images/Login/LazzoTexto.png" alt="Lazzo">
            </figure>
        </div>

        </div>
    </main>

    </div>  

    <script src="pagina-login.js"></script>
</body>
</html>