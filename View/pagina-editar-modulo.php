<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassMaster - Editar Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="../Templates/css/pagina-editar-modulo.css">
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
 <div id="modules-grid" class="modules-grid">
            <!-- Os cards serão gerados dinamicamente aqui -->
        </div>
    </main>

    <!-- Modal de Edição de Módulo (inicialmente oculto) -->
    <div id="editModuleModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h2 id="modal-course-title">Chat GPT no dia a dia: Automatize tarefas com texto</h2>
                <button id="closeModal" class="close-button">&times;</button>
            </div>
            <div class="modal-body">
                <!-- Formulário de edição -->
                <form id="editModuleForm">
                    <!-- Campo oculto para armazenar o ID do módulo que está sendo editado -->
                    <input type="hidden" id="editing-module-id" name="moduleId">

                    <div class="form-grid-modal">
                        <!-- Coluna da Esquerda -->
                        <div class="form-column-modal">
                            <div class="form-group">
                                <label for="module-title">Título</label>
                                <input type="text" id="module-title" name="moduleTitle">
                            </div>
                            <div class="form-group">
                                <label for="module-duration">Tempo de Duração</label>
                                <input type="text" id="module-duration" name="moduleDuration" placeholder="Ex: 1h30">
                            </div>
                        </div>
                        <!-- Coluna da Direita -->
                        <div class="form-column-modal">
                            <div class="form-group">
                                <label>Capa do Módulo</label>
                                <div class="module-cover">
                                    <img src="" alt="Capa do módulo" id="modal-cover-image">
                                    <label for="modal-cover-upload" class="edit-cover-btn">
                                        <i class="bi bi-pencil"></i>
                                    </label>
                                    <input type="file" id="modal-cover-upload" name="moduleCover" accept="image/*" style="display: none;">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</main>

    <img src="../Images/Pagina-Inicial/lazzinho.png" alt="Mascote" class="mascot">

    <!-- Script para ativar os ícones Feather -->
    <script>
        feather.replace( );
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../Templates/js/pagina-editar-modulo.js"></script>


</body>
</html>
