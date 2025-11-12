<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAi | Novo Curso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../Templates/css/pagina-de-cursos-professor.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body>

    <header>
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

        <div class="header_mobile">
            <img src="../Images/Página suporte/logoMaster.png" alt="Imagem logo ClassAII" class="img-logo">
            
            <div class="user-profile-mobile-group">
                <img src="../Images/Página de Apresentação/Lazo.png" alt="Avatar do Usuário" class="user-avatar-mobile">
                <img src="../Images/Ícones do header/setinha perfil.png" alt="Seta" class="arrow-icon">
            </div>
        </div>
    </header>

    <main class="container-fluid">
        <div class="row">
            <div class="col-12">
                <a href="#" class="back-link">
                    <i class="bi bi-chevron-left"></i> Novo Curso
                </a>
            </div>
        </div>

        <form class="course-form">
            <div class="row g-5">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="course-title">Título</label>
                        <input type="text" id="course-title" class="form-control" placeholder="Digite aqui...">
                    </div>

                    <div class="form-group mt-4">
                        <label for="course-description">Descrição</label>
                        <textarea id="course-description" class="form-control" rows="5" placeholder="Digite aqui..."></textarea>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label>Capa do Curso</label>
                        <label for="course-cover" class="cover-upload-area">
                        <i class="bi bi-plus-circle-fill"></i>
                        </label>
                        <input type="file" id="course-cover" class="d-none">
                    </div>
                </div>
            </div>

            <div class="row g-5 mt-3">
                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="course-professions">Profissões Recomendadas</label>
                        <input type="text" id="course-professions" class="form-control" placeholder="Digite aqui...">
                        <button type="button" class="btn-add-profession">
                            <i class="bi bi-plus-circle-fill"></i> Adicionar profissão
                        </button>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="form-group">
                        <label for="course-difficulty">Nível de dificuldade</label>
                        <input type="text" id="course-difficulty" class="form-control" placeholder="Ex: Iniciante">
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-12 text-center">
                    <button type="button" class="btn-add-modules">
                        <i class="bi bi-plus-lg"></i> Adicionar Módulos
                    </button>
                </div>
            </div>
        </form>
        
    </main>

</body>
</html>
