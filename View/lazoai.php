<?php $pageTitle = "Lazo AI"; ?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    
    <!-- Corrigindo para o nome do arquivo CSS com DOIS Zs -->
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>templates/css/lazoai.css">
</head>
<body>
    <div class="chat-container">
        <header class="chat-header">
            <div class="header-content">
                <a href="<?php echo BASE_URL; ?>index.php" class="close-button">&times;</a>
                <h1>Lazo AI</h1>
            </div>
            <img src="<?php echo BASE_URL; ?>images/lazo_mascot.png" alt="Mascote Lazo AI" class="mascot">
        </header>
        <main id="chat-body" class="chat-body">
            <div class="welcome-message">
                <h2>Faça uma pergunta à Lazo</h2>
                <p>A IA irá te ajudar no processo de aprendizagem</p>
            </div>
        </main>
        <footer class="chat-footer">
            <div class="input-wrapper">
                <input type="text" id="chat-input" placeholder="Digite sua pergunta">
                <button id="send-button" class="send-button">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="white"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path></svg>
                </button>
            </div>
        </footer>
    </div>
    
    <!-- CORREÇÃO CRÍTICA: Usando o nome do arquivo com DOIS Zs, como na sua estrutura -->
    <script src="<?php echo BASE_URL; ?>templates/js/lazoai.js"></script>
</body>
</html>
