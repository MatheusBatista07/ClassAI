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
        <a href="">
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
            <input type="text" name="userEmail" class="userEmail" placeholder="E-mail">
            <p class="msg_erro"  style="color: red;">este campo é obrigatório</p>
            <input type="text" name="userPassword" class="userPassword" placeholder="Senha">
            <p class="msg_erro"  style="color: red;">este campo é obrigatório</p>
            <p class="esqueceuSenha" style="color: #C37BFF">Esqueceu a senha?</p>
            </div>

            <div class="buttons">
                <a href="https://accounts.google.com/v3/signin/accountchooser?dsh=S1930013800%3A1760449800043570&elo=1&ifkv=AfYwgwXw6nL7aYaFXBT9ctMlYrS5YZZXUvRLyOiyCQpWJtM7WKLA9ww8TZizvliCwOEeET5L_2_m&flowName=GlifWebSignIn&flowEntry=ServiceLogin" class="continuarCom"> <img class="logo" src="../Images/Login/Logo Google.png" alt="Logo Google"> Continuar com o Google</a>
                <a href="" class="continuarCom"> <img class="logo" src="../Images/Login/Logo Apple.png" alt="Logo Apple"> Continuar com a Apple</a>
                <button class="entrar">Entrar</button>
            </div>
            <p class="nao_tem_conta" style="color: #C37BFF">Não tem conta? <a class="cadastre_se" href="" style="color: #C37BFF">Cadastre-se</a></p>
        </form>

        <div class="lazzo">
            <figure>
                <img class="lazzoImg" src="../Images/Login/LazzoTexto.png" alt="Lazzo">
            </figure>
        </div>
        </div>
    </main>

    </div>  

    <script src="pagina-login.js"></script>
</body>
</html>