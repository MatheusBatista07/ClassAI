<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/vendor/autoload.php';

$action = $_GET['action'] ?? '';

$acoesProtegidas = ['sendMessage', 'getMessages'];
if (in_array($action, $acoesProtegidas) && !isset($_SESSION['usuario_id'])) {
    http_response_code(403 );
    echo json_encode(['status' => 'error', 'message' => 'Acesso negado. Usuário não autenticado.']);
    exit;
}

try {
    $controller = new \Controller\ChatController();

    switch ($action) {
        case 'getMessages':
            $userId = $_SESSION['usuario_id']; 
            $contactId = $_GET['contactId'] ?? 0;
            
            if ($contactId == 0) {
                 http_response_code(400 );
                 echo json_encode(['status' => 'error', 'message' => 'contactId é obrigatório.']);
                 exit;
            }
            $controller->getMessages($userId, $contactId);
            break;

        case 'sendMessage':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->sendMessage();
            } else {
                http_response_code(405 );
                echo json_encode(['status' => 'error', 'message' => 'Método não permitido para esta ação.']);
            }
            break;

        case 'pusherAuth':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->pusherAuth();
            }
            break;

        default:
            http_response_code(404 );
            echo json_encode(['status' => 'error', 'message' => 'Endpoint de API não encontrado.']);
            break;
    }

} catch (Throwable $e) {
    http_response_code(500 );
    echo json_encode([
        'status' => 'error',
        'message' => 'Erro fatal no servidor durante a execução da API.',
        'error_details' => [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]
    ]);
}
?>
