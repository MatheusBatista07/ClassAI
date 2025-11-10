<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAi | Suporte</title>
    <!-- O caminho para o CSS foi ajustado para refletir a estrutura de pastas -->
    <link rel="stylesheet" href="../Templates/css/paginaSuporte.css">
    <!-- Ícone para o botão de enviar -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

    <header>
        <!-- Cabeçalho para Desktop -->
        <a href="index.php">
            <figure>
                <img src="../Images/Página suporte/logoMaster.png" alt="Logo ClassAi Master" class="logo">
            </figure>
        </a>
        
        <div class="header-icons">
            <div class="header-icon">
                <img src="../Images/Ícones do header/lazzo.png" alt="Imagem lazzo" class="lazzo_img">
            </div>
            <div class="header-icon">
                <i class="bi bi-bell"></i>
            </div>
            <div class="user-profile">
                <img src="../Images/Página de Apresentação/Lazo.png" alt="Avatar do Usuário" class="user-avatar">
                <img src="../Images/Ícones do header/setinha perfil.png" alt="Seta" class="arrow-icon">
            </div>
        </div>

        <!-- Cabeçalho para Mobile (Estrutura Corrigida ) -->
        <div class="header_mobile">
            <img src="../Images/Página suporte/logoMaster.png" alt="Imagem logo ClassAII" class="img-logo">
            
            <!-- Grupo de perfil para alinhamento correto -->
            <div class="user-profile-mobile-group">
                <img src="../Images/Página de Apresentação/Lazo.png" alt="Avatar do Usuário" class="user-avatar-mobile">
                <img src="../Images/Ícones do header/setinha perfil.png" alt="Seta" class="arrow-icon">
            </div>
        </div>
    </header>

    <div class="container">
        <main>
            <div class="back-link">
                <a href="paginaAnterior.php"> <i class="bi bi-arrow-left"></i> Suporte </a>
            </div>
            <div class="conteudo_principal">
                <div class="imagem-suporte">
                    <img src="../Images/Página suporte/girl.png" alt="Ilustração de suporte">
                </div>
                <form action="paginaSuporte.php" method="POST" class="formulario">
                    <div class="input-group">
                        <label for="tipo-problema">Tipo do Problema</label>
                        <input type="text" id="tipo-problema" name="tipo-problema" placeholder="Ex: Avisos">
                    </div>
                    <div class="input-group">
                        <label for="mensagem">Mensagem</label>
                        <textarea id="mensagem" name="mensagem" placeholder="Digite aqui..."></textarea>
                    </div>
                    <div class="input-group">
                        <label for="telefone">Número de Telefone</label>
                        <input type="text" id="telefone" name="telefone" placeholder="Ex: (xx ) xxxxx-xxxx">
                    </div>
                    <button type="submit" class="botao-enviar">
                        Enviar <i class="bi bi-send-fill"></i>
                    </button>
                </form>
            </div>
        </main>
    </div>
</body>

</html>
