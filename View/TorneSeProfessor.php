<?php
session_start();
$feedback = $_SESSION['feedback'] ?? null;
unset($_SESSION['feedback']);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Torne-se um Instrutor - ClassAI</title>
    <link rel="stylesheet" href="../Templates/css/pagina-aplicacao-professor.css">
</head>
<body>
    <header class="header-aplicacao">
        <a href="../index.php">
            <img src="../Images/Icones-do-header/Logo-ClassAi-branca.png" alt="Logo ClassAi">
        </a>
    </header>

    <div class="main-container">
        <div class="form-wrapper">
            <h1>Torne-se um Instrutor na ClassAI</h1>
            <p class="subtitulo">Preencha o formulário abaixo. Nossa equipe analisará sua aplicação e entrará em contato.</p>

            <?php if ($feedback): ?>
                <div class="feedback-message <?php echo htmlspecialchars($feedback['status']); ?>">
                    <?php echo htmlspecialchars($feedback['message']); ?>
                </div>
            <?php endif; ?>

            <form action="../processa_aplicacao.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nome_completo">Nome Completo</label>
                    <input type="text" id="nome_completo" name="nome_completo" required>
                </div>
                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="telefone">Telefone (Opcional)</label>
                    <input type="tel" id="telefone" name="telefone">
                </div>
                <div class="form-group">
                    <label for="formacao">Sua Principal Formação ou Título</label>
                    <input type="text" id="formacao" name="formacao" placeholder="Ex: Doutor em IA, Desenvolvedor Sênior" required>
                </div>
                <div class="form-group">
                    <label for="link_portfolio">Link para Portfólio ou LinkedIn</label>
                    <input type="url" id="link_portfolio" name="link_portfolio" placeholder="https://linkedin.com/in/seu-perfil" required>
                </div>

                <div class="form-group">
                    <label for="foto_perfil">Foto de Perfil (Opcional )</label>
                    <div class="file-upload-wrapper">
                        <label for="foto_perfil" class="file-upload-button">
                            <i class="bi bi-person-bounding-box"></i> Escolher foto
                        </label>
                        <input type="file" id="foto_perfil" name="foto_perfil" accept="image/png, image/jpeg, image/gif">
                        <span id="foto-file-name" class="file-name-display">Nenhuma foto escolhida</span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="carta_apresentacao">Por que você quer ser um instrutor na ClassAI?</label>
                    <textarea id="carta_apresentacao" name="carta_apresentacao" rows="5" required></textarea>
                </div>
                
                <div class="form-group">
                    <label>Anexe seu Currículo (PDF ou DOCX)</label>
                    <div class="file-upload-wrapper">
                        <label for="curriculo" class="file-upload-button">
                            <i class="bi bi-upload"></i> Escolher arquivo
                        </label>
                        <input type="file" id="curriculo" name="curriculo" accept=".pdf,.doc,.docx" required>
                        <span id="file-name" class="file-name-display">Nenhum arquivo escolhido</span>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-submit">Enviar Aplicação</button>
                </div>
            </form>
        </div>
    </div>

    <script>
    document.getElementById('curriculo').addEventListener('change', function() {
        const fileNameDisplay = document.getElementById('file-name');
        if (this.files.length > 0) {
            fileNameDisplay.textContent = this.files[0].name;
        } else {
            fileNameDisplay.textContent = 'Nenhum arquivo escolhido';
        }
    });

    document.getElementById('foto_perfil').addEventListener('change', function() {
        const fileNameDisplay = document.getElementById('foto-file-name');
        if (this.files.length > 0) {
            fileNameDisplay.textContent = this.files[0].name;
        } else {
            fileNameDisplay.textContent = 'Nenhuma foto escolhida';
        }
    });
    </script>

</body>
</html>
