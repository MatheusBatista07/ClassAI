<?php
if (isset($_GET['action']) && $_GET['action'] === 'askLazo') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    register_shutdown_function(function() {
        $error = error_get_last();
        if ($error !== null && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
            header('Content-Type: text/plain');
            http_response_code(500 );
            echo "ERRO FATAL CAPTURADO:\n\n";
            print_r($error);
        }
    });
}

header('Content-Type: application/json');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Config/Configuration.php';

$action = $_GET['action'] ?? '';

$acoesProtegidas = ['sendMessage', 'getMessages', 'askLazo', 'pusherAuth', 'getFollowList'];
if (in_array($action, $acoesProtegidas) && !isset($_SESSION['usuario_id'])) {
    http_response_code(403 );
    echo json_encode(['status' => 'error', 'message' => 'Acesso negado.']);
    exit;
}

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

        case 'getFollowList':
            require_once __DIR__ . '/Model/UserModel.php';
            $userModel = new \Model\UserModel();
            
            $userId = $_GET['userId'] ?? null;
            $type = $_GET['type'] ?? null;

            if (!$userId || !$type) {
                http_response_code(400 );
                echo json_encode(['status' => 'error', 'message' => 'Dados inválidos.']);
                exit;
            }
            
            $list = [];
            if ($type === 'followers') {
                $list = $userModel->getSeguidores($userId);
            } elseif ($type === 'following') {
                $list = $userModel->getSeguindo($userId);
            }

            foreach ($list as &$user) {
                $user['foto_perfil_url'] = '/ClassAI/' . ($user['foto_perfil_url'] ?? 'Images/perfil_padrao.png');
            }

            echo json_encode(['status' => 'success', 'list' => $list]);
            break;

        default:
            http_response_code(404 );
            echo json_encode(['status' => 'error', 'message' => 'Endpoint não encontrado.']);
            break;
    }
} catch (Throwable $e) {
    http_response_code(500 );
    echo json_encode([
        'status' => 'error',
        'message' => 'Erro capturado no try-catch: ' . $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine()
    ]);
}
?>
