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
                // =====================================================================
                // CORREÇÃO: Forçando o cluster correto 'us2'
                // =====================================================================
                ['cluster' => 'us2', 'useTLS' => true]
            );
        } catch (PusherException $e) {
            // Em um ambiente de produção, você logaria o erro em vez de usar 'die'.
            error_log("Erro ao conectar com o Pusher: " . $e->getMessage());
            http_response_code(500 );
            die(json_encode(['status' => 'error', 'message' => 'Não foi possível conectar ao serviço de tempo real.']));
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
            $this->pusher->trigger($channelName, $eventName, $payload, ['socket_id' => $socketId]);
            
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
        return $userModel->getContatosAmigos($currentUserId);
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

        $userId = $_SESSION['usuario_id'];
        $userInfo = [
            'nome' => $_SESSION['usuario_nome'] ?? 'Anônimo',
            'foto_url' => $_SESSION['usuario_foto_url'] ?? null
        ];

        try {
            $auth = $this->pusher->authorizePresenceChannel($channelName, $socketId, $userId, $userInfo);
            
            header('Content-Type: application/json');
            echo $auth;
            exit();

        } catch (\Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            error_log('Pusher Auth Error: ' . $e->getMessage());
            echo 'Erro ao autenticar no Pusher.';
            exit();
        }
    }
}
