<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/Model/UserModel.php';
require_once __DIR__ . '/Model/ChatModel.php';
require_once __DIR__ . '/Controller/ChatController.php';

$action = $_GET['action'] ?? '';

try {
    $controller = new \Controller\ChatController();

    switch ($action) {
        case 'getMessages':
            $userId = $_GET['userId'] ?? 0;
            $contactId = $_GET['contactId'] ?? 0;
            
            if ($userId == 0 || $contactId == 0) {
                 http_response_code(400 );
                 echo json_encode(['status' => 'error', 'message' => 'userId e contactId são obrigatórios.']);
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
