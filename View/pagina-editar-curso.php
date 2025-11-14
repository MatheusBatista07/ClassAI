<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassMaster - Editar Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="../Templates/css/pagina-editar-curso.css">
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


    <div class="page-title">
        <a href="#" class="back-link"><i data-feather="chevron-left"></i></a>
        <h1>Customizar Curso</h1>
    </div>
    <!-- Conteúdo Principal -->
<main class="content-area">
    <!-- INÍCIO DO FORMULÁRIO DE CUSTOMIZAÇÃO -->
    <form class="course-form" method="UPDATE">
        <div class="form-grid">
            <!-- Coluna da Esquerda -->
            <div class="form-column">
                <!-- Campo Título -->
                <div class="form-group">
                    <label for="course-title">Título</label>
                    <input type="text" id="course-title" placeholder="TÍTULO QUE ESTÁ NO BANCO DE DADOS">
                </div>

                <!-- Campo Descrição -->
                <div class="form-group">
                    <label for="course-description">Descrição</label>
                    <textarea id="course-description" rows="4" placeholder="DESCRIÇÃO QUE ESTÁ NO BANCO DE DADOS"></textarea>
                </div>

                <!-- Campo Profissões Recomendadas -->
                <div class="form-group">
                    <label>Profissões Recomendadas</label>
                    <div id="professions-list">
                        <!-- AQUI É ONDE O USUÁIO VAI ADICIONAR AS PROFISSÕES -->
                    </div>
                    <button type="button" id="add-profession-btn" class="add-profession-btn">
                        <i class="bi bi-plus-circle"></i>
                        <span>Adicionar profissão</span>
                    </button>
                </div>
            </div>

            <!-- Coluna da Direita -->
            <div class="form-column">
                <!-- Campo Capa do Curso -->
                <div class="form-group">
                    <label>Capa do Curso</label>
                    <div class="course-cover">
                        <img src="https://i.imgur.com/sT8xY3k.jpeg" alt="Capa do curso com um laptop e um carro em miniatura" id="cover-image">
                        <label for="cover-upload" class="edit-cover-btn">
                            <i class="bi bi-pencil"></i>
                        </label>
                        <input type="file" id="cover-upload" accept="image/*" style="display: none;">
                    </div>
                </div>

                <!-- Campo Nível de Dificuldade -->
                <div class="form-group">
                    <label for="course-difficulty">Nível de dificuldade</label>
                    <select id="course-difficulty">
                        <option>Iniciante</option>
                        <option>Intermediário</option>
                        <option>Avançado</option>
                    </select>
                </div>
            </div>
        </div>

       <div class="form-actions">
            <a href="pagina-de-edicao-de-modulos.php" class="btn-secondary">Editar Módulos</a>
            <button type="submit" class="btn-primary">Confirmar Alterações</button>
        </div>
    </form>
    <!-- FIM DO FORMULÁRIO DE CUSTOMIZAÇÃO -->

</main>

    <img src="../Images/Pagina-Inicial/lazzinho.png" alt="Mascote" class="mascot">

    <!-- Script para ativar os ícones Feather -->
    <script>
        feather.replace( );
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../Templates/js/pagina-editar-curso.js"></script>


</body>
</html>
