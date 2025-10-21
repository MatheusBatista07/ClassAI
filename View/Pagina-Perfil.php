<?php
if (isset($_GET['action']) && $_GET['action'] !== '') {
    header('Content-Type: application/json');

    try {
        $configPath = __DIR__ . '/../Config/Configuration.php';
        if (!file_exists($configPath)) {
            throw new Exception('Arquivo de configuração não encontrado: ' . $configPath);
        }
        require_once $configPath;

        $courseModelPath = __DIR__ . '/../Model/CursosModel.php';

        if (!file_exists($courseModelPath)) {
            throw new Exception('Model Course não encontrado: ' . $courseModelPath);
        }

        require_once $courseModelPath;

        $courseModel = new CursosModel();

        $action = $_GET['action'];

        switch ($action) {
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
    <title>Meu Perfil</title>
    <link rel="stylesheet" href="../Templates/css/Pagina-Perfil.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

    <header class="main-header">
        <div class="logo">
            <img src="../Images/Ícones do header/Logo ClassAI branca.png" alt="ClassAI Logo">
        </div>
    </header>

    <div class="container">
        <div class="left-column">

            <div class="profile-header">
                <div class="profile-photo-wrapper">
                    <img src="../Images/Pagina Perfil/foto-jeferson-brito.png" alt="Foto do Usuário" class="profile-photo">
                </div>
                <button class="btn-edit">
                    <i class="fas fa-pencil-alt"></i> Editar
                </button>
                <div class="profile-username">@sza_jeff</div>
            </div>

            <div class="social-stats">
                <span>Segue <strong>50</strong></span>
                <span>Seguidores <strong>60</strong></span>
            </div>

            <!-- DETALHES DO USUÁRIO (NOME, EMAIL, ETC.) -->
            <div class="user-details">
                <div class="detail-item">
                    <h2>Nome completo</h2>
                    <p>Jeferson Brito Souza</p>
                </div>
                <div class="detail-item">
                    <h2>Nome de Usuário</h2>
                    <p>Jeferson Souza</p>
                </div>
                <div class="detail-item">
                    <h2>E-mail</h2>
                    <p>jefsouza@gmail.com</p>
                </div>
                <div class="detail-item">
                    <h2>Formação Profissional</h2>
                    <p>Técnico em Logística</p>
                </div>
                <div class="detail-item">
                    <h2>Descrição</h2>
                    <p>Tenho 23 anos, sou formado como Técnico em Logística e atualmente sou aluno dessa plataforma de ensino online. Gosto de aprender coisas novas, estou sempre em busca de me aprimorar e aplicar o que estudo na prática, buscando crescer tanto profissional quanto pessoalmente.</p>
                </div>
            </div>

            <!-- AÇÕES DO PERFIL (ALTERAR CONTA / LOGOUT) -->
            <div class="profile-actions">
                <a href="#">Alterar conta</a>
                <a href="#">Fazer logout</a>
            </div>
        </div>

        <!-- ======================= COLUNA DA DIREITA (HISTÓRICO E CURSOS) ======================= -->
        <div class="right-column">
            <div class="platform-history">
                <h2 class="section-title">Histórico na plataforma</h2>
                <div class="stats-wrapper">
                    <div class="stat-card">
                        <div class="stat-icon-wrapper purple">
                            <i class="fas fa-book-open"></i>
                        </div>
                        <div class="stat-info">
                            <p>Cursos em Andamento</p>
                            <span>2 Cursos</span>
                        </div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-icon-wrapper green">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="stat-info">
                            <p>Cursos Concluídos</p>
                            <span>3 Cursos</span>
                        </div>
                    </div>
                </div>
                <div class="consistency-card">
                    <div class="consistency-number">80</div>
                    <div class="consistency-text">dias de Constância</div>
                </div>
            </div>

            <div class="courses-section">
                <h3 class="section-title">Cursos Favoritados</h3>
                <div class="carousel-wrapper">
                    <div id="courses-list" class="courses-list">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../Templates/js/Cursos.js"></script>
</body>

</html>