<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../Model/QuizModel.php';
require_once __DIR__ . '/../Model/CursosModel.php'; // Para buscar o nome da aula
require_once __DIR__ . '/../Model/UserModel.php';

use Model\QuizModel;
use Model\CursosModel;
use Model\UserModel;

// Validação inicial
$userId = $_SESSION['usuario_id'] ?? null;
$aulaId = filter_input(INPUT_GET, 'aula_id', FILTER_VALIDATE_INT);

if (!$userId || !$aulaId) {
    die("Acesso inválido.");
}

// Busca dos dados
$userModel = new UserModel();
$usuarioLogado = $userModel->encontrarUsuarioPorId($userId);
$fotoUsuario = !empty($usuarioLogado['foto_perfil_url']) ? '/ClassAI/' . htmlspecialchars($usuarioLogado['foto_perfil_url']) : 'https://via.placeholder.com/40';

$cursosModel = new CursosModel( );
$aula = $cursosModel->getAulaById($aulaId);

$quizModel = new QuizModel();
$questoes = $quizModel->getQuestoesByAulaId($aulaId);

if (!$aula || empty($questoes)) {
    die("Quiz não encontrado para esta aula.");
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz: <?php echo htmlspecialchars($aula['titulo_aula']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../Templates/css/pagina-quiz.css">
</head>
<body>
    <div class="sidebar">
        <img src="../Images/Icones-do-header/Logo-ClassAI-branca.png" alt="Logo ClassAI" class="img-logo">
        <ul class="nav-menu">
            <li class="nav-item"><a href="PaginaHome.php" class="nav-link"><i class="bi bi-house-door"></i> Principal</a></li>
            <li class="nav-item"><a href="paginaChat.php" class="nav-link"><i class="bi bi-chat"></i> Chat</a></li>
            <li class="nav-item"><a href="PaginaPrincipalCursos.php" class="nav-link active"><i class="bi bi-book"></i> Cursos</a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-award"></i> Certificados</a></li>
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-people"></i> Amigos</a></li>
        </ul>
        <div class="nav-divider"></div>
        <ul class="nav-menu">
            <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-question-circle"></i> Ajuda e FAQ</a></li>
            <li class="nav-item"><a href="#" class="nav-link">Modo escuro <i class="bi bi-moon-stars ms-auto"></i></a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <div></div>
            <div class="header-icons">
                <div class="header-icon"><img src="../Images/Icones-do-header/lazzo.png" alt="Ícone Lazzo" class="lazzo_img"></div>
                <div class="header-icon"><i class="bi bi-bell"></i></div>
                <div class="user-profile">
                    <img src="<?php echo $fotoUsuario; ?>" alt="Avatar do Usuário" class="user-avatar">
                    <img src="../Images/Icones-do-header/setinha-perfil.png" alt="Seta" class="arrow-icon">
                </div>
            </div>
        </div>

        <div class="quiz-container">
            <a href="pagina-material.php?aula_id=<?php echo $aulaId; ?>" class="btn-voltar"><i class="bi bi-arrow-left"></i> Voltar para o Material</a>
            
            <div class="quiz-header">
                <h2>Quiz: <?php echo htmlspecialchars($aula['titulo_aula'] ); ?></h2>
                <div class="progress-container">
                    <div class="progress-bar" id="progress-bar"></div>
                    <span id="progress-text">Questão 1 de <?php echo count($questoes); ?></span>
                </div>
            </div>

            <div id="quiz-body">
                <?php foreach ($questoes as $index => $questao): ?>
                    <div class="question-block <?php echo $index === 0 ? 'active' : ''; ?>" data-question-index="<?php echo $index; ?>">
                        <h3 class="question-title"><?php echo htmlspecialchars($questao['enunciado_questao']); ?></h3>
                        <div class="options-container">
                            <?php foreach ($questao['opcoes'] as $opcao): ?>
                                <div class="option" data-correct="<?php echo $opcao['correta'] ? 'true' : 'false'; ?>">
                                    <?php echo htmlspecialchars($opcao['texto_opcao']); ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="quiz-navigation">
                <button id="prev-btn" class="btn-nav" disabled>Anterior</button>
                <button id="next-btn" class="btn-nav">Próxima</button>
                <button id="finish-btn" class="btn-nav finish" style="display: none;">Finalizar Quiz</button>
            </div>

            <div id="result-container" style="display: none;">
                <h3>Resultado do Quiz</h3>
                <p>Você acertou <span id="score">0</span> de <?php echo count($questoes); ?> questões!</p>
                <div id="feedback-list"></div>
                <a href="pagina-material.php?aula_id=<?php echo $aulaId; ?>" class="btn-nav">Voltar para o Material</a>
            </div>
        </div>
    </div>

    <script src="../Templates/js/pagina-quiz.js"></script>
</body>
</html>
