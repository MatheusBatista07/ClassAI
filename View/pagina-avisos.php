<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ClassMaster - Avisos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="stylesheet" href="../Templates/css/paginaAvisos.css">
</head>
<body>

    <!-- Cabeçalho Superior -->
    <header class="main-header">
        <div class="logo">
            <img src="../Images/Icones-do-header/LogoClassaiMaster.png" alt="">
        </div>
        
        <div class="header-icons">
                <div class="header-icon"><img src="../Images/Icones-do-header/lazzo.png" alt="Imagem lazzo" class="lazzo_img"></div>
                <div class="header-icon">
                    <i class="bi bi-bell"></i>
                </div>
                <div class="user-profile">
                <img src="https://via.placeholder.com/40" alt="Avatar do Usuário" class="user-avatar">
                <img src="../Images/Icones-do-header/setinha-perfil.png" alt="Seta" class="arrow-icon">
                </div>
            </div>
    </header>

    <!-- Conteúdo Principal -->
     <main class="container">
        <div class="page-title">
            <a href="#" class="back-link"><img src="../Images/Pagina-Inicial/seta-p-esquerda.png" alt=""> Avisos</a>
        </div>

        <div class="content-grid">
            <!-- Seção de Avisos Recentes -->
            <section class="recent-notices">
                <h2 class="titulo">Avisos Recentes</h2>
                <div class="notice-card">
                    <h3><i class="bi bi-exclamation-square"></i> Aviso Importante!</h3>
                    <p>Olá! Lembre-se de que a entrega do trabalho deve ser feita até sexta-feira. Não deixe para a última hora!</p>
                    <p class="signature">Atenciosamente,  
Prof. Ana Luisa Dev</p>
                    <div class="notice-footer">
                        <span><i class="far fa-clock"></i> Seg, 20/10 - 10h</span>
                        <span class="tag">ChatGPT no dia a dia: Automatize tarefas importantes</span>
                    </div>
                </div>
            </section>

            <!-- Seção de Novo Aviso -->
            <section class="new-notice">
                <h2 class="titulo-new">Novo Aviso</h2>
                <form class="notice-form">
                    <div class="form-group">
                        <input type="text" id="title" name="title" placeholder="Título do aviso">
                    </div>
                    <div class="form-group">
                        <textarea id="content" name="content" rows="6" placeholder="Digite aqui o texto principal do seu aviso..."></textarea>
                    </div>
                    <div class="form-group">
                        <input type="text" id="publish-date" name="publish-date" placeholder="Data de publicação">
                    </div>
                    <div class="form-group">
                        <input type="text" id="course" name="course" placeholder="Curso referenciado">
                    </div>
                    <button type="submit" class="submit-btn">Publicar</button>
                </form>
            </section>
        </div>
    </main>

    <!-- Mascote no canto -->
    <img src="../Images/Página Inicial/lazinho.png" alt="Mascote" class="mascot">

    <!-- Script para ativar os ícones Feather -->
    <script>
        feather.replace( );
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>