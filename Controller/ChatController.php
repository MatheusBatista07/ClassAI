<?php

namespace Controller;

use Model\ChatModel;
use Model\UserModel;
use Pusher\Pusher;
use Pusher\PusherException;

class ChatController {

    private $pusher;
    private $chatModel;

    public function __construct() {
        require_once __DIR__ . '/../Config/Configuration.php';
        $this->chatModel = new ChatModel();

        try {
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
        
        $success = $this->chatModel->saveMessage($senderId, $receiverId, $messageText);
        
        if ($success) {
            $channelName = 'private-chat-' . min($senderId, $receiverId) . '-' . max($senderId, $receiverId);
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

    public function getContactList(int $currentUserId): array
    {
        $userModel = new UserModel();
        return $userModel->getTodosUsuarios($currentUserId);
    }

    public function pusherAuth()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['usuario_id'])) {
            header('HTTP/1.1 403 Forbidden');
            echo 'Acesso negado.';
            exit;
        }

        $socketId = $_POST['socket_id'] ?? '';
        $channelName = $_POST['channel_name'] ?? '';
        
        if (empty($socketId) || empty($channelName)) {
            header('HTTP/1.1 400 Bad Request');
            echo 'socket_id e channel_name são obrigatórios.';
            exit;
        }

        $presenceData = [
            'id' => $_SESSION['usuario_id'],
            'name' => $_SESSION['usuario_nome'] ?? 'Usuário Anônimo'
        ];

        try {
            $auth = $this->pusher->presence_auth($channelName, $socketId, $presenceData['id'], $presenceData);
            echo $auth;
        } catch (\Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            error_log('Pusher Auth Error: ' . $e->getMessage());
            echo 'Erro ao autenticar no Pusher.';
        }
    }
}
