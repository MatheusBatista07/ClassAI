<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassMaster - Cursos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="../Templates/css/pagina-lista-cursos.css">
</head>
<body>

    <!-- Cabeçalho Superior -->
    <header>
        <a href="index.php">
            <figure>
                <img src="../Images/Icones-do-header/logoMaster.png" alt="Logo ClassAi Master" class="logo">
            </figure>
        </a>
        
        <div class="header-icons">
            <div class="header-icon">
                <i class="bi bi-bell"></i>
            </div>
            <div class="user-profile">
                <img src="" alt="Avatar do Usuário" class="user-avatar">
                <img src="../Images/Icones-do-header/setinha perfil.png" alt="Seta" class="arrow-icon">
            </div>
        </div>

        <div class="header_mobile">
            <img src="../Images/Icones-do-header/logoMaster.png" alt="Imagem logo ClassAII" class="img-logo">
            
            <div class="user-profile-mobile-group">
                <img src="" alt="Avatar do Usuário" class="user-avatar-mobile">
                <img src="../Images/Icones-do-header/setinha perfil.png" alt="Seta" class="arrow-icon">
            </div>
        </div>
    </header>

    <!-- Conteúdo Principal -->
    <main class="content-area">
        
        <div class="page-title">
            <a href="#" class="back-link"><i data-feather="chevron-left"></i></a>
            <h1>Cursos</h1>

            <div class="search-bar">
                <input type="text" placeholder="Pesquisar">
                <i data-feather="search" class="search-icon"></i>
            </div>
        </div>


        <ul class="student-list">
            
            <li class="student-item">
                <a href="pagina-editar-curso.php" class="chat-icon" style="color: white; text-decoration: none">
                <div class="student-info">
                    <i class="bi bi-play-fill"></i>
                    <span>Chat GPT no dia a dia: Automatize tarefas com texto</span>
                </div>
                    </a>
                    
                
                    <button class="deletar" style="background-color: transparent; border: none; " >
                        <i class="bi bi-trash" style="color: #BD0606"></i>
                    </button>
                
            </li>
            
            (aqui abaixo ficam os outros cursos, caso tenham)

        </ul>


<div id="deleteModal" class="modal-overlay" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Confirmar Exclusão</h2>
            <button id="closeModal" class="close-button">&times;</button>
        </div>
        <div class="modal-body">
            <p>Você tem certeza de que deseja excluir este curso?</p>
            <!-- A linha que mostrava o nome do curso foi removida daqui -->
            <p class="warning-text">Esta ação não poderá ser desfeita.</p>
        </div>
        <div class="modal-footer">
            <button id="cancelDelete" class="btn btn-secondary">Cancelar</button>
            <button id="confirmDelete" class="btn btn-danger">Sim, Excluir</button>
        </div>
    </div>
</div>



    </main>

    <!-- Mascote no canto -->
    <img src="../Images/Pagina-Inicial/lazzinho.png" alt="Mascote" class="mascot">

    <!-- Script para ativar os ícones Feather -->
    <script>
        feather.replace( );
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../Templates/js/pagina-lista-cursos.js"></script>


</body>
</html>
