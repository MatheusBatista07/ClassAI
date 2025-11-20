<?php
// Descobre o nome do arquivo da página atual (ex: PaginaHome.php)
$paginaAtual = basename($_SERVER['PHP_SELF']);
?>

<!-- Link para o CSS da Sidebar. ESSENCIAL! -->
<link rel="stylesheet" href="/ClassAI/Templates/css/PaginaHome.css">

<div class="sidebar">
    <img src="/ClassAI/Images/Icones-do-header/Logo-ClassAI-branca.png" alt="Imagem logo ClassAI" class="img-logo">

    <ul class="nav-menu">
        <li class="nav-item">
            <a href="PaginaHome.php" class="nav-link <?php echo ($paginaAtual == 'PaginaHome.php') ? 'active' : ''; ?>">
                <i class="bi bi-house-door"></i> Principal
            </a>
        </li>
        <li class="nav-item">
            <a href="paginaChat.php" class="nav-link <?php echo ($paginaAtual == 'paginaChat.php') ? 'active' : ''; ?>">
                <i class="bi bi-chat"></i> Chat
            </a>
        </li>
        <li class="nav-item">
            <a href="PaginaPrincipalCursos.php" class="nav-link <?php echo ($paginaAtual == 'PaginaPrincipalCursos.php') ? 'active' : ''; ?>">
                <i class="bi bi-book"></i> Cursos
            </a>
        </li>
        <li class="nav-item"><a href="#" class="nav-link"><i class="bi bi-award"></i> Certificados</a></li>
        
        <!-- ===== LINHA ALTERADA ===== -->
        <li class="nav-item">
            <a href="pagina-amigos.php" class="nav-link <?php echo ($paginaAtual == 'pagina-amigos.php') ? 'active' : ''; ?>">
                <i class="bi bi-people"></i> Amigos
            </a>
        </li>
        <!-- ========================== -->

    </ul>

    <div class="nav-divider"></div>

    <ul class="nav-menu">
        <li class="nav-item">
            <a href="#" class="nav-link">
                <i class="bi bi-question-circle"></i> Ajuda e FAQ
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
