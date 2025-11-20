<?php
// Arquivo: api.php (VERSÃO DE DEPURAÇÃO)

// --- MODO DE DEPURAÇÃO PARA 'askLazo' ---
if (isset($_GET['action']) && $_GET['action'] === 'askLazo') {
    // Força a exibição de TODOS os erros possíveis, não importa o que aconteça.
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    // Define um manipulador de erros personalizado para capturar erros fatais.
    register_shutdown_function(function() {
        $error = error_get_last();
        if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
            header('Content-Type: text/plain'); // Responde como texto puro para ver o erro
            http_response_code(500 );
            echo "ERRO FATAL CAPTURADO:\n\n";
            print_r($error);
        }
    });
}
// --- FIM DO MODO DE DEPURAÇÃO ---


// O resto do seu script começa aqui.
header('Content-Type: application/json');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Config/Configuration.php';

$action = $_GET['action'] ?? '';

$acoesProtegidas = ['sendMessage', 'getMessages', 'askLazo'];
if (in_array($action, $acoesProtegidas) && !isset($_SESSION['usuario_id'])) {
    http_response_code(403 );
    echo json_encode(['status' => 'error', 'message' => 'Acesso negado.']);
    exit;
}

// O try...catch original
try {
    switch ($action) {
        case 'getMessages':
        case 'sendMessage':
        case 'pusherAuth':
            $controller = new \Controller\ChatController();
            if ($action === 'getMessages') $controller->getMessages($_SESSION['usuario_id'], $_GET['contactId'] ?? 0);
            if ($action === 'sendMessage') $controller->sendMessage();
            if ($action === 'pusherAuth') $controller->pusherAuth();
            break;

        case 'askLazo':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $lazoController = new \Controller\LazoController(); 
                $lazoController->askLazo();
            } else {
                http_response_code(405 );
                echo json_encode(['status' => 'error', 'message' => 'Método não permitido.']);
            }
            break;

        default:
            http_response_code(404 );
            echo json_encode(['status' => 'error', 'message' => 'Endpoint não encontrado.']);
            break;
    }
} catch (Throwable $e) {
    // O bloco catch original
    http_response_code(500 );
    echo json_encode([
        'status' => 'error',
        'message' => 'Erro capturado no try-catch: ' . $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}
?>
