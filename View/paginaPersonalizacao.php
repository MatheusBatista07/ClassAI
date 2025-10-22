<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAi | Cadastro</title>
    <link rel="stylesheet" href="../Templates/css/paginaPersonalizacao.css">
    <!-- Link para os ícones do Bootstrap (necessário para o '+') -->
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
                <form action="" class="formulario">
                    <h1>Vamos deixar com a sua cara agora!</h1>
                    <h2>Seus dados estão protegidos!</h2>

                    <div class="form-layout">
                        <div class="top-row">
                            <div class="upload-container">
                                <input type="file" id="foto-perfil" name="foto-perfil" accept="image/*"
                                    style="display: none;">
                                <label for="foto-perfil" class="upload-label">
                                    <i class="bi bi-plus"></i>
                                </label>
                            </div>
                            <div class="field-wrapper">
                                <input type="text" name="userName" class="userName form-control" placeholder="Usuário">
                                <small class="msg-erro nome-erro">Por favor, digite seu nome de usuário.</small>
                            </div>
                        </div>
                        <div class="bottom-row">
                            <textarea name="descricao" class="userDescription form-control"
                                placeholder="Descrição"></textarea>
                        </div>
                    </div>

                    <div class="buttons">
                        <button class="entrar" type="button" id="btnCadastrar">Finalizar</button>
                    </div>
                </form>

                <div class="lazzo">
                    <figure>
                        <img class="lazzoImg" src="../Images/Página de Login e Cadastro/LazzoPf.png" alt="Lazzo">
                    </figure>
                </div>
            </div>
        </main>
    </div>

    <script src="../Templates/js/paginaPersonalizacao.js"></script>

</body>

</html>