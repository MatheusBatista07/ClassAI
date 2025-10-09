<?php
// View/Pagina-perfil-amigo.php - CAMINHOS CORRIGIDOS

// Verificar se é requisição API
if (isset($_GET['action']) && $_GET['action'] !== '') {
    // Headers para API
    header('Content-Type: application/json');

    try {
        // CONFIGURAÇÃO - CAMINHO CORRETO
        $configPath = __DIR__ . '/../Config/Configuration.php';
        if (!file_exists($configPath)) {
            throw new Exception('Arquivo de configuração não encontrado: ' . $configPath);
        }
        require_once $configPath;

        // MODELS - CAMINHOS CORRETOS
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
</head>

<body>
    <div class="container">
        <!-- Coluna da Esquerda - Perfil -->
        <div class="left-column">
            <div class="profile-card">
                <div class="profile-header">
                    <img src="../Images/Fotos Pagina Perfil amigo/Jose-Felipe.png" alt="José Felipe"
                        class="profile-photo">
                    <div class="profile-info">
                        <h1 class="profile-name">José Felipe</h1>
                        <div class="profile-username">@felipejose</div>
                        <div class="profile-title">Técnico em Logística Aluno</div>
                    </div>
                </div>

                <div class="profile-stats">
                    <div class="stat">
                        <div class="stat-value">Seguindo</div>
                        <div class="stat-number">50</div>
                    </div>
                    <div class="stat">
                        <div class="stat-value">Seguidores</div>
                        <div class="stat-number">60</div>
                    </div>
                </div>

                <div class="navigation">
                    <div class="nav-item active">Chat</div>
                </div>
            </div>

            <!-- Sugestão de Amigos -->
            <div class="friends-section">
                <h3 class="section-title">Sugestão de amigos</h3>
                <div id="friends-list" class="friends-grid">
                    <div class="loading">Carregando amigos...</div>
                </div>
            </div>
        </div>

        <!-- Coluna da Direita - Conteúdo -->
        <div class="right-column">
            <!-- Descrição do Perfil -->
            <div class="description-section">
                <h3 class="section-title">Sobre</h3>
                <div class="description-content">
                    <p>Tenho 23 anos, sou formado como Técnico em Logística e atualmente sou aluno dessa plataforma de
                        ensino online. Gosto de aprender coisas novas, estou sempre em busca de me aprimorar e aplicar o
                        que estudo na prática, buscando crescer tanto profissional quanto pessoalmente.</p>
                </div>
            </div>

            <!-- Histórico na Plataforma -->
            <div class="profile-content">
                <div class="platform-history">
                    <h2 class="section-title">Histórico na plataforma</h2>
                    <div class="stats-cards">
                        <div class="stat-card">
                            <div class="card-bg">
                                <img src="../Images/Fotos Pagina Perfil amigo/Fundo-Curso-Andamento.png" alt="Fundo Curso Andamento" class="bg-image">
                                <img src="../Images/Fotos Pagina Perfil amigo/Cursos-Andamento.png" alt="Cursos Andamento" class="main-image">
                            </div>
                            <div class="card-content">
                                <div class="stat-number">1</div>
                                <div class="stat-label">Cursos em Andamento</div>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="card-bg">
                                <img src="../Images/Fotos Pagina Perfil amigo/Fundo-Curso-Concluido.png" alt="Fundo Curso Concluído" class="bg-image">
                                <img src="../Images/Fotos Pagina Perfil amigo/Cursos-Concluidos.png" alt="Cursos Concluídos" class="main-image">
                            </div>
                            <div class="card-content">
                                <div class="stat-number">10</div>
                                <div class="stat-label">Cursos Concluídos</div>
                            </div>
                        </div>

                            <!-- Dias de Constância -->
                            <div class="consistency-section">
                                <h3 class="section-title">22 dias de Constância</h3>
                                <div class="consistency-number">22</div>
                            </div>

                            <!-- Cursos mais bem avaliados -->
                            <div class="courses-section">
                                <h3 class="section-title">Cursos mais bem avaliados</h3>
                                <div id="courses-list" class="courses-list">
                                    <div class="loading">Carregando cursos...</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <script src="../Templates/js/Pagina-perfil-amigo.js"></script>
</body>

</html>