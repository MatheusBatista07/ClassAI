<?php

namespace Controller;

use Model\ChatModel;
use Model\UserModel;
use Pusher\Pusher;
use Pusher\PusherException;

class ChatController {

    private Pusher $pusher;
    private ChatModel $chatModel;

    public function __construct(ChatModel $chatModel = null, Pusher $pusher = null) {
        $this->chatModel = $chatModel ?? new ChatModel();

        if ($pusher) {
            $this->pusher = $pusher;
        } else {
            require_once __DIR__ . '/../Config/Configuration.php';
            try {
                $this->pusher = new Pusher(
                    PUSHER_APP_KEY,
                    PUSHER_APP_SECRET,
                    PUSHER_APP_ID,
                    ['cluster' => PUSHER_APP_CLUSTER, 'useTLS' => true]
                );
            } catch (PusherException $e) {
                error_log("Pusher instantiation failed: " . $e->getMessage());
            }
        }
    }
    
    public function sendMessage() {
        date_default_timezone_set('America/Sao_Paulo');

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
            $channelName = 'private-chat-user-' . $receiverId;
            $eventName = 'new-message';
            $payload = [
                'senderId' => $senderId,
                'receiverId' => $receiverId,
                'message' => $messageText,
                'timestamp' => date('Y-m-d H:i:s')
            ];
            
            $socketId = $data['socket_id'] ?? null;
            
            try {
                $this->pusher->trigger($channelName, $eventName, $payload, ['socket_id' => $socketId]);
            } catch (PusherException $e) {
                error_log("Pusher trigger failed: " . $e->getMessage());
            }
            
            echo json_encode(['status' => 'success', 'message' => 'Mensagem enviada.']);
        } else {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(['status' => 'error', 'message' => 'Falha ao salvar a mensagem no banco de dados.']);
        }
    }
    
    public function getMessages(int $userId, int $contactId) {
        $messages = $this->chatModel->fetchMessages($userId, $contactId);
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
            $auth = $this->pusher->authorizePresenceChannel($channelName, $socketId, $presenceData['id'], $presenceData);
            echo $auth;
        } catch (\Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            error_log('Pusher Auth Error: ' . $e->getMessage());
            echo 'Erro ao autenticar no Pusher.';
        }
    }
}
