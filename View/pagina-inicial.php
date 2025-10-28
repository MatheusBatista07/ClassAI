<?php
session_start();

if (!isset($_SESSION['usuario_id'])) {
    header('Location: paginaLogin.php');
    exit; 
}


$nomeDoUsuario = $_SESSION['usuario_nome'] ?? 'Usuário';

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicial | ClassAi</title>
    <style>
        body { font-family: sans-serif; display: flex; flex-direction: column; align-items: center; justify-content: center; height: 100vh; background-color: #f4f4f9; }
        .welcome-box { padding: 40px; background-color: white; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); text-align: center; }
        h1 { color: #333; }
        a { color: #C37BFF; text-decoration: none; font-weight: bold; margin-top: 20px; display: inline-block; }
    </style>
</head>
<body>

    <div class="welcome-box">
        <h1>Bem-vindo(a) à Página Inicial, <?php echo htmlspecialchars($nomeDoUsuario); ?>!</h1>
        <p>Você está logado no ClassAi.</p>
        
        <a href="logout.php">Sair</a>
    </div>

</body>
</html>
