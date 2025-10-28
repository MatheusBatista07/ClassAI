<?php
// api.php (na raiz do projeto)

// ====================================================================
// 1. A LINHA MAIS IMPORTANTE: CARREGAR O AUTOLOAD DO COMPOSER
// Isso deve ser a PRIMEIRA coisa a acontecer.
// Ele ensina o PHP sobre todas as classes do seu projeto (Pusher, Controller, Model).
require_once __DIR__ . '/vendor/autoload.php';
// ====================================================================


// 2. Defina os cabeçalhos da API
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET");

// 3. Use a classe ChatController que o autoload já carregou
use Controller\ChatController;

// 4. Crie a instância do controller
// Agora esta linha vai funcionar, pois o autoload já carregou o Pusher.
$controller = new ChatController();

// 5. Roteamento (o resto do código permanece o mesmo)
$action = $_GET['action'] ?? '';

switch ($action) {
    case 'getMessages':
        $userId = $_GET['userId'] ?? 0;
        $contactId = $_GET['contactId'] ?? 0;
        $controller->getMessages($userId, $contactId);
        break;

    case 'sendMessage':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controller->sendMessage();
        } else {
            header("HTTP/1.1 405 Method Not Allowed");
            echo json_encode(['status' => 'error', 'message' => 'Método não permitido.']);
        }
        break;

    default:
        header("HTTP/1.1 404 Not Found");
        echo json_encode(['status' => 'error', 'message' => 'Endpoint não encontrado.']);
        break;
}
?>
