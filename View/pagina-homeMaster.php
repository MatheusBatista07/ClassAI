<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassAI - Página Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../Templates/css/PaginaHomeMaster.css">
    <link rel="stylesheet" href="../Templates/css/paginaChat.css">
</head>

<body data-user-id="<?php echo htmlspecialchars($userId ); ?>">
    <div class="sidebar">
        <img src="../Images/Ícones do header/LogoClassaiMaster.png" alt="Imagem logo ClassAII" class="img-logo">

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="PaginaHome.php" class="nav-link"><i class="bi bi-house-door"></i> Principal</a>
            </li>
            <li class="nav-item">
                <a href="paginaChat.php" class="nav-link"><i class="bi bi-chat"></i> Chat</a>
            </li>
            <li class="nav-item">
                <a href="PaginaPrincipalCursos.php" class="nav-link"><i class="bi bi-book"></i> Cursos</a>
            </li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-award"></i> Certificados</a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-people"></i> Amigos</a></li>
            <li class="nav-item"><a href="#" class="nav-link active"><i class="bi bi-person-video3"></i> Master</a></li>
        </ul>

        <div class="nav-divider"></div>

        <ul class="nav-menu">
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="bi bi-question-circle"></i>
                    Ajuda e FAQ
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    Modo escuro
                    <i class="bi bi-moon-stars ms-auto"></i>
                </a>
            </li>
        </ul>
    </div>

    <div class="main-content">
        <header class="header">
            <div></div>
            <div class="header-icons">
                <div class="header-icon">
                    <img src="../Images/Ícones do header/lazzo.png" alt="Imagem lazzo" class="lazzo_img">
                </div>
                <div class="header-icon">
                    <i class="bi bi-bell"></i>
                </div>

                <div class="user-profile">
                    <img src="<?php echo htmlspecialchars($fotoUsuario); ?>" alt="Avatar de <?php echo htmlspecialchars($nomeCompleto); ?>" class="user-avatar">
                    <img src="../Images/Ícones do header/setinha perfil.png" alt="Seta" class="arrow-icon">
                </div>
            </div>
            <div class="header_mobile">
                <img src="../Images/Ícones do header/Logo ClassAI branca.png" alt="Imagem logo ClassAII" class="img-logo">
                <i class="bi bi-list"></i>
            </div>
        </header>

        <main class="container-fluid">
            
            <div class="row g-4">
                <div class="col-lg-8">

                            <h2 class="user-name">
                                <span class="decorated-name"><?php echo htmlspecialchars($nomeCompleto); ?></span>
                            </h2>
                            <p class="user-course"><?php echo htmlspecialchars(ucfirst($funcaoUsuario)); ?></p>

                    <section class="row g-4 mb-4">
                        <div class="col-md-6">
                            <a href="#" class="summary-card">
                                <div class="card-icon-wrapper in-progress">
                                    <img src="../Images/Pagina-HomeMaster/suporte.png" alt="Ferramentas cruzadas">
                                </div>
                                <div class="summary-info">
                                    <h3 class="summary-title">Suporte</h3>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-6">
                            <a href="#" class="summary-card">
                                <div class="card-icon-wrapper in-progress">
                                    <img src="../Images/Pagina-HomeMaster/NovoCurso.png" alt="Ferramentas cruzadas">
                                </div>
                                <div class="summary-info">
                                    <h3 class="summary-title">Novo Curso</h3>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-6">
                            <a href="#" class="summary-card">
                                <div class="card-icon-wrapper in-progress">
                                    <img src="../Images/Pagina-HomeMaster/CustomizarCurso.png" alt="Ferramentas cruzadas">
                                </div>
                                <div class="summary-info">
                                    <h3 class="summary-title">Customizar Curso</h3>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="summary-card">
                                <div class="card-icon-wrapper in-progress">
                                    <img src="../Images/Pagina-HomeMaster/Alunos.png" alt="Ferramentas cruzadas">
                                </div>
                                <div class="summary-info">
                                    <h3 class="summary-title">Alunos</h3>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="summary-card">
                                <div class="card-icon-wrapper in-progress">
                                    <img src="../Images/Pagina-HomeMaster/Aviso.png" alt="Ferramentas cruzadas">
                                </div>
                                <div class="summary-info">
                                    <h3 class="summary-title">Aviso</h3>
                                </div>
                            </a>
                        </div>

                        <div class="col-md-6">
                            <a href="#" class="summary-card">
                                <div class="card-icon-wrapper in-progress">
                                    <img src="../Images/Pagina-HomeMaster/sair.png" alt="Ferramentas cruzadas">
                                </div>
                                <div class="summary-info">
                                    <h3 class="summary-title">Sair</h3>
                                </div>
                            </a>
                        </div>
                    </section>
                    
                    <section>
                        <h1 class="monit">Monitoramento</h1>
                        <div class="monitoramento">
                            <div class="cardss">
                                <h1>Certificados Emitidos</h1>
                                <p>****</p>
                            </div>

                            <div class="cardss">
                                <h1>Alunos Matriculados</h1>
                                <p>****</p>
                            </div>

                            <div class="cardss">
                                <h1>Cursos Postados</h1>
                                <p>****</p>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

