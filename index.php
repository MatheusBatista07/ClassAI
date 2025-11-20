<?php
define('ROOT_PATH', __DIR__);
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$script_name = str_replace('index.php', '', $_SERVER['SCRIPT_NAME'] );
define('BASE_URL', $protocol . "://" . $host . $script_name);

require_once ROOT_PATH . '/Config/LazoConfiguration.php';
require_once ROOT_PATH . '/Controller/LazoController.php';


$action = $_GET['action'] ?? null;
if ($action === 'askLazo') {
    $userController = new UserController();
    $userController->askLazo();
    exit; 
}


?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página de Teste do Chatbot</title>
    

    <link rel="stylesheet" href="<?php echo BASE_URL; ?>templates/css/lazoai.css">
    
    <style>
  
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #120c1ccf;
            color: #f0f0f0;
            padding: 40px;
        }
        h1 { color: var(--primary-purple); }
    </style>
</head>
<body>

    <h1>Página Principal de Teste</h1>
    <p>O componente do chatbot deve aparecer aqui.</p>

    <?php
 
    require_once ROOT_PATH . '/View/lazoai.php';
    ?>

</body>
</html>
