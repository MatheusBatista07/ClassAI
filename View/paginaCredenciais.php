<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAi | Cadastro</title>
    <link rel="stylesheet" href="../Templates/css/paginaCredenciais.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
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
            <h1 style=" color: white">Preencha seus dados!</h1>
                    <h2 style="color: white">Protegidos com segurança</h2>

                    <div class="inputs">
                        <!-- Campo Nome -->
                        <input type="text" name="userName" class="userName form-control" placeholder="Nome">
                        <small class="msg-erro nome-erro" style="color: red; display: none;">Por favor, digite seu
                            nome.</small>

                        <!-- Campo Sobrenome -->
                        <input type="text" name="userLastName" class="userLastName form-control"
                            placeholder="Sobrenome">
                        <small class="msg-erro sobrenome-erro" style="color: red; display: none;">Por favor, digite seu
                            sobrenome.</small>

                        <!-- Campo CPF -->
                        <input type="text" name="userCPF" class="userCPF form-control" placeholder="CPF">
                        <small class="msg-erro cpf-erro" style="color: red; display: none;">Por favor, digite seu
                            CPF.</small>

                        <div class="buttons">
                            <button class="entrar" type="button" id="btnCadastrar" class="btn btn-primary"
                                style="margin-top: 15px;">Continuar</button>
                        </div>
                    </div>




                </form>

                <div class="lazzo">
                    <figure>
                        <img class="lazzoImg" src="../Images/Página de Login e Cadastro/LazzoCadastro.png" alt="Lazzo">
                    </figure>
                </div>
            </div>
        </main>

    </div>
</body>
<script src="../Templates/js/paginaCredenciais.js"></script>

</html>