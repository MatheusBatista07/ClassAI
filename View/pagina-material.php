<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../Model/CursosModel.php';
require_once __DIR__ . '/../Model/UserModel.php';

use Model\CursosModel;
use Model\UserModel;

$userId = $_SESSION['usuario_id'] ?? null;
$aulaId = $_GET['aula_id'] ?? null;

if (!$aulaId || !$userId) {
    die("Acesso inválido.");
}

$cursosModel = new CursosModel();
$aula = $cursosModel->getAulaById((int)$aulaId);

if (!$aula) {
    die("Material não encontrado.");
}

$userModel = new UserModel();
$usuarioLogado = $userModel->encontrarUsuarioPorId($userId);
$fotoUsuario = !empty($usuarioLogado['foto_perfil_url']) ? '/ClassAI/' . htmlspecialchars($usuarioLogado['foto_perfil_url']) : 'https://via.placeholder.com/40';
?>
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Material: <?php echo htmlspecialchars($aula['titulo_aula'] ); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../Templates/css/pagina-material.css">
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

        <div class="material-area">
            <a href="pagina-modulo.php?mod_id=<?php echo $aula['id_mod_fk']; ?>" class="btn-voltar">
                <i class="bi bi-arrow-left-circle"></i> Voltar para o Módulo
            </a>

            <header class="material-header">
                <h1>Material de Apoio: <?php echo htmlspecialchars($aula['titulo_aula'] ); ?></h1>
            </header>

            <div class="material-content">
                <?php if (!empty($aula['material_aula'])): ?>
                    <p><?php echo nl2br(htmlspecialchars($aula['material_aula'])); ?></p>
                <?php else: ?>
                    <div class="alert alert-secondary">Nenhum material de apoio cadastrado para esta aula.</div>
                <?php endif; ?>
            </div>

            <div class="quiz-section">
                <h2>Pronto para testar seus conhecimentos?</h2>
                <p>Após estudar o material, clique no botão abaixo para fazer um pequeno quiz e validar seu aprendizado.</p>
                <a href="pagina-quiz.php?aula_id=<?php echo $aula['id_aula']; ?>" class="btn-quiz">
                    <i class="bi bi-check2-circle"></i> Iniciar Quiz
                </a>
            </div>
        </div>
    </div>
</body>
</html>
