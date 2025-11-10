<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassMaster - Alunos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="../Templates/css/paginaAlunos.css">
</head>
<body>

    <!-- Cabeçalho Superior -->
    <header class="main-header">
        <div class="logo">
            <img src="../Images/Ícones do header/LogoClassaiMaster.png" alt="">
        </div>
        
        <div class="header-icons">
                <div class="header-icon"><img src="../Images/Ícones do header/lazzo.png" alt="Imagem lazzo" class="lazzo_img"></div>
                <div class="header-icon">
                    <i class="bi bi-bell"></i>
                </div>
                <div class="user-profile">
                <img src="https://via.placeholder.com/40" alt="Avatar do Usuário" class="user-avatar">
                <img src="../Images/Ícones do header/setinha perfil.png" alt="Seta" class="arrow-icon">
                </div>
            </div>
    </header>

    <!-- Conteúdo Principal -->
    <main class="content-area">
        
        <div class="page-title">
            <a href="#" class="back-link"><i data-feather="chevron-left"></i></a>
            <h1>Alunos</h1>

            <div class="search-bar">
                <input type="text" placeholder="Pesquisar">
                <i data-feather="search" class="search-icon"></i>
            </div>
        </div>


        <ul class="student-list">
            <li class="student-item">
                <div class="student-info">
                    <img src="https://i.imgur.com/exemplo-aluno.jpg" alt="Foto do Aluno" class="student-avatar">
                    <span>Alisson Neves Ventura</span>
                </div>
                <a href="#" class="chat-icon">
                    <i class="bi bi-chat"></i>
                </a>
            </li>
            <!-- Você pode adicionar mais alunos aqui -->
            <li class="student-item">
                <div class="student-info">
                    <img src="https://i.imgur.com/outro-aluno.jpg" alt="Foto do Aluno" class="student-avatar">
                    <span>Outro Aluno de Exemplo</span>
                </div>
                <a href="#" class="chat-icon">
                    <i class="bi bi-chat"></i>
                </a>
            </li>
        </ul>
    </main>

    <!-- Mascote no canto -->
    <img src="../Images/Página Inicial/lazinho.png" alt="Mascote" class="mascot">

    <!-- Script para ativar os ícones Feather -->
    <script>
        feather.replace( );
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
