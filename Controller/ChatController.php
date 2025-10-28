<?php
// Controller/ChatController.php

// 1. Declaramos que este arquivo pertence ao namespace 'Controller'
namespace Controller;

// 2. Importamos as classes de OUTROS namespaces que vamos usar.
use Model\ChatModel;
use Pusher\Pusher;
use Pusher\PusherException;

class ChatController {

    private $pusher;
    private $chatModel;

    public function __construct() {
        // Carrega as constantes de configuração.
        require_once __DIR__ . '/../Config/Configuration.php';

        // ====================================================================
        // A ÚNICA MUDANÇA É AQUI: Adicionamos uma '\' na frente de Model\ChatModel
        // Isso força o PHP a procurar a classe no namespace correto definido pelo autoloader.
        $this->chatModel = new \Model\ChatModel();
        // ====================================================================

        try {
            // A classe Pusher será encontrada por causa do 'use Pusher\Pusher;' no topo.
            $this->pusher = new Pusher(
                PUSHER_APP_KEY,
                PUSHER_APP_SECRET,
                PUSHER_APP_ID,
                ['cluster' => PUSHER_APP_CLUSTER, 'useTLS' => true]
            );
        } catch (PusherException $e) {
            die("Erro ao conectar com o Pusher: " . $e->getMessage());
        }
    }
    
    // Nenhuma alteração necessária nas funções abaixo
    public function sendMessage() {
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['senderId'], $data['receiverId'], $data['message'])) {
            header("HTTP/1.1 400 Bad Request");
            echo json_encode(['status' => 'error', 'message' => 'Dados incompletos.']);
            return;
        }
        $senderId = (int)$data['senderId'];
        $receiverId = (int)$data['receiverId'];
        $messageText = htmlspecialchars($data['message']);
        
        // Esta linha agora deve funcionar, pois $this->chatModel foi criado corretamente.
        $success = $this->chatModel->saveMessage($senderId, $receiverId, $messageText);
        
        if ($success) {
            $channelName = 'chat-' . min($senderId, $receiverId) . '-' . max($senderId, $receiverId);
            $eventName = 'new-message';
            $payload = [
                'senderId' => $senderId,
                'receiverId' => $receiverId,
                'message' => $messageText,
                'timestamp' => date('Y-m-d H:i:s')
            ];
            $this->pusher->trigger($channelName, $eventName, $payload);
            echo json_encode(['status' => 'success', 'message' => 'Mensagem enviada.']);
        } else {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(['status' => 'error', 'message' => 'Falha ao salvar a mensagem no banco de dados.']);
        }
    }
    
    public function getMessages($userId, $contactId) {
        $messages = $this->chatModel->fetchMessages((int)$userId, (int)$contactId);
        header('Content-Type: application/json');
        echo json_encode($messages);
    }
}
?>
