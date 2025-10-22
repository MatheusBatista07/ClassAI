<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAi | Cadastro</title>
    <link rel="stylesheet" href="../Templates/css/paginaDeCadastro.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
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
            <h1 style=" color: white">Que bom ver você!</h1>
                    <h2 style="color: white">O seu futuro começa aqui!</h2>

                    <div class="inputs">
                        <input type="text" name="userEmail" class="userEmail form-control" placeholder="E-mail">
                        <small class="msg-erro email-erro" style="color: red; display: none;">Digite seu e-mail</small>

                        <label class="password-label">
                            <input type="password" name="userPassword" id="userPassword" class="userPassword form-control" placeholder="Senha">
                            <i class="bi bi-eye-slash" id="togglePassword"></i>
                        </label>
                        <small class="msg-erro senha-erro" style="color: red; display: none;">Digite sua senha</small>

                        <label class="password-label">
                            <input type="password" name="userPasswordConfirm" id="userPasswordConfirm" class="userPasswordConfirm form-control" placeholder="Confirmar senha">
                            <i class="bi bi-eye-slash" id="togglePasswordConfirm"></i>
                        </label>
                        <small class="msg-erro confirma-erro" style="color: red; display: none;">As senhas não conferem</small>
                        
                        <div class="form-check" style="color: #C37BFF; margin-top: 10px;">
                            <input class="form-check-input" type="checkbox" id="termosCheck" required>
                            <label class="form-check-label" for="termosCheck">
                                Li e estou de acordo com o
                                <a href="#" style="color: #C37BFF; text-decoration: underline;">Termo de Uso</a>
                                e
                                <a href="#" style="color: #C37BFF; text-decoration: underline;">Política de Privacidade</a>
                            </label>
                        </div>
                        <small class="msg-erro termos-erro" style="color: red; display: none;">Você precisa aceitar os termos</small>

                        <div class="buttons">
                            <button class="entrar" type="button" id="btnCadastrar" class="btn btn-primary">Cadastrar</button>
                        </div>
                    </div>


                    <p class="nao_tem_conta" style="color: #C37BFF">Já tem conta? <a class="cadastre_se" href=""
                            style="color: #C37BFF">Entrar</a></p>
                </form>

                <div class="lazzo">
                    <figure>
                        <img class="lazzoImg" src="../Images/Página de Login e Cadastro/LazzoCadastro.png" alt="Lazzo">
                    </figure>
                </div>
            </div>
        </main>

    </div>
    <script src="../Templates/js/paginaDeCadastro.js"></script>
    <script src="../Templates/js/MostrarSenha.js"></script>
</body>

</html>