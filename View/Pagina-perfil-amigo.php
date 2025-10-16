<?php
if (isset($_GET['action']) && $_GET['action'] !== '') {
    header('Content-Type: application/json');

    try {
        $configPath = __DIR__ . '/../Config/Configuration.php';
        if (!file_exists($configPath)) {
            throw new Exception('Arquivo de configuração não encontrado: ' . $configPath);
        }
        require_once $configPath;

        $friendModelPath = __DIR__ . '/../Model/FriendModel.php';
        $courseModelPath = __DIR__ . '/../Model/CourseModel.php';

        if (!file_exists($friendModelPath)) {
            throw new Exception('Model Friend não encontrado: ' . $friendModelPath);
        }
        if (!file_exists($courseModelPath)) {
            throw new Exception('Model Course não encontrado: ' . $courseModelPath);
        }

        require_once $friendModelPath;
        require_once $courseModelPath;

        $friendModel = new FriendModel();
        $courseModel = new CourseModel();

        $action = $_GET['action'];

        switch ($action) {
            case 'getFriends':
                $friends = $friendModel->getAllFriends();
                echo json_encode([
                    'success' => true,
                    'data' => $friends
                ]);
                break;

            case 'getCourses':
                $courses = $courseModel->getAllCourses();
                echo json_encode([
                    'success' => true,
                    'data' => $courses
                ]);
                break;

            default:
                echo json_encode(['success' => false, 'error' => 'Ação não encontrada: ' . $action]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'error' => 'Erro: ' . $e->getMessage()
        ]);
    }
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil - José Felipe</title>
    <link rel="stylesheet" href="../Templates/css/Pagina-perfil-amigo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

    <header class="main-header">
        <div class="logo">
            <img src="../Images/Ícones do header/Logo ClassAI branca.png" alt="ClassAIB Logo">
        </div>

        <div class="user-menu">
            <img src="../Images/Fotos Pagina Perfil amigo/retangulo-foto-header.png" alt="" class="user-menu-background">
            <img src="../Images/Fotos Pagina Perfil amigo/foto-pessoas-header.png" alt="Avatar do Usuário" class="user-menu-avatar">
            <img src="../Images/Fotos Pagina Perfil amigo/seta-foto-header.png" alt="Abrir menu" class="user-menu-arrow">
        </div>
    </header>



    <div class="container">
        <div class="left-column">

            <div class="profile-card">
                <div class="back-arrow">
                    <i class="fas fa-arrow-left"></i>
                </div>

                <div class="profile-header">

                    <img src="../Images/Fotos Pagina Perfil amigo/Jose-Felipe.png" alt="José Felipe" class="profile-photo">

                    <div class="profile-info">
                        <h1 class="profile-name">José Felipe</h1>
                        <div class="profile-username">@felipejose</div>
                        <div class="profile-title">Técnico em Logística</div>
                        <div class="profile-title">Aluno</div>
                    </div>

                </div>


                <div class="profile-buttons">
                    <button class="btn btn-primary">Seguindo</button>
                    <button class="btn btn-secondary">Chat</button>
                </div>
                <div class="social-stats">
                    <div class="stats-pill">
                        <span>Segue <strong>50</strong></span>
                        <span>Seguidores <strong> 60 </strong></span>
                    </div>
                </div>
            </div>


            <div class="friends-section">
                <h3 class="section-title">Sugestão de amigos</h3>

                <div class="friends-list-wrapper">
                    <div id="friends-list" class="friends-grid">
                        <div class="loading">Carregando amigos...</div>
                    </div>
                    <div class="see-more">
                        <i class="fas fa-chevron-right"></i>
                        <span>Ver mais</span>
                    </div>
                </div>
            </div>

            <div class="description-section">
                <div class="description-content">
                    <p>Tenho 23 anos, sou formado como Técnico em Logística e atualmente sou aluno dessa plataforma de
                        ensino online. Gosto de aprender coisas novas, estou sempre em busca de me aprimorar e
                        aplicar o
                        que estudo na prática, buscando crescer tanto profissional quanto pessoalmente.</p>
                </div>
            </div>
        </div>

        <div class="right-column">
            <div class="platform-history">
                <h2 class="section-title">Histórico na plataforma</h2>
                <div class="stats-cards">
                    <!-- INÍCIO DA ALTERAÇÃO: Novo grupo para os cards de cima -->
                    <div class="stats-cards-row">
                        <div class="stat-card">
                            <div class="stat-card-icon">
                                <img src="../Images/Fotos Pagina Perfil amigo/Fundo-Curso-Andamento.png" alt=""
                                    class="icon-background">
                                <img src="../Images/Fotos Pagina Perfil amigo/Cursos-Andamento.png"
                                    alt="Ícone de Cursos em Andamento" class="icon-foreground">
                            </div>
                            <div class="stat-card-info">
                                <p>Cursos em Andamento</p>
                                <span>1 Curso</span>
                            </div>
                        </div>

                        <div class="stat-card">
                            <div class="stat-card-icon">
                                <img src="../Images/Fotos Pagina Perfil amigo/Fundo-Curso-Concluido.png" alt=""
                                    class="icon-background">
                                <img src="../Images/Fotos Pagina Perfil amigo/Cursos-Concluidos.png"
                                    alt="Ícone de Cursos Concluídos" class="icon-foreground">
                            </div>
                            <div class="stat-card-info">
                                <p>Cursos Concluídos</p>
                                <span>10 Cursos</span>
                            </div>
                        </div>
                    </div>
                    <div class="consistency-section">
                        <div class="consistency-number">22</div>
                        <div class="consistency-text">dias de
                            Constância</div>
                    </div>

                </div>
            </div>

            <div class="courses-section">
                <h3 class="section-title">Cursos mais bem avaliados</h3>
                <div id="courses-list" class="courses-list">
                    <div class="loading">Carregando cursos...</div>
                </div>
            </div>
        </div>

    </div>

    <script src="../Templates/js/Amigos.js"></script>
    <script src="../Templates/js/Cursos.js"></script>
</body>

</html>