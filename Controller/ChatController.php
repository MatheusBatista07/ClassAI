<?php

namespace Controller;

use Model\ChatModel;
use Model\UserModel;
use Model\NotificationModel; // 1. Importamos o novo Model
use Pusher\Pusher;
use Pusher\PusherException;

class ChatController
{
    private $pusher;
    private $chatModel;
    private $userModel;
    private $notificationModel;

    // 2. Construtor refatorado para injeção de dependência (melhor para testes e organização)
    public function __construct(ChatModel $chatModel = null, UserModel $userModel = null, NotificationModel $notificationModel = null, Pusher $pusher = null)
    {
        require_once __DIR__ . '/../Config/Configuration.php';
        
        $this->chatModel = $chatModel ?? new ChatModel();
        $this->userModel = $userModel ?? new UserModel();
        $this->notificationModel = $notificationModel ?? new NotificationModel();

        if ($pusher) {
            $this->pusher = $pusher;
        } else {
            try {
                $this->pusher = new Pusher(PUSHER_APP_KEY, PUSHER_APP_SECRET, PUSHER_APP_ID, ['cluster' => PUSHER_APP_CLUSTER, 'useTLS' => true]);
            } catch (PusherException $e) {
                error_log("Erro ao conectar com o Pusher: " . $e->getMessage());
                // Lidar com o erro de conexão, se necessário
            }
        }
    }
    
    public function sendMessage()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['senderId'], $data['receiverId'], $data['message'])) {
            http_response_code(400 );
            echo json_encode(['status' => 'error', 'message' => 'Dados incompletos.']);
            return;
        }

        $senderId = (int)$data['senderId'];
        $receiverId = (int)$data['receiverId'];
        $messageText = htmlspecialchars($data['message']);
        
        $success = $this->chatModel->saveMessage($senderId, $receiverId, $messageText);
        
        if ($success) {
            // Dispara o evento para o chat em tempo real
            $chatChannel = 'private-chat-user-' . $receiverId;
            $chatPayload = [
                'senderId' => $senderId,
                'receiverId' => $receiverId,
                'message' => $messageText,
                'timestamp' => date('Y-m-d H:i:s')
            ];
            $socketId = $data['socket_id'] ?? null;
            $this->pusher->trigger($chatChannel, 'new-message', $chatPayload, ['socket_id' => $socketId]);

            // =====================================================================
            // 3. LÓGICA DE NOTIFICAÇÃO ADICIONADA AQUI
            // =====================================================================
            $senderInfo = $this->userModel->encontrarUsuarioPorId($senderId);
            $senderName = $senderInfo ? $senderInfo['nome'] : 'Alguém';
            
            $notificationMessage = "Você tem uma nova mensagem de {$senderName}.";
            $notificationLink = "../View/pagina-chat.php?contactId={$senderId}";

            $this->notificationModel->criarNotificacao($receiverId, 'nova_mensagem', $notificationMessage, $senderId, $notificationLink);

            // Dispara o evento para a notificação em tempo real
            $notificationChannel = 'notifications-user-' . $receiverId;
            $notificationPayload = [
                'message' => $notificationMessage,
                'link' => $notificationLink
            ];
            $this->pusher->trigger($notificationChannel, 'new-notification', $notificationPayload);
            // =====================================================================

            echo json_encode(['status' => 'success', 'message' => 'Mensagem enviada.']);
        } else {
            http_response_code(500 );
            echo json_encode(['status' => 'error', 'message' => 'Falha ao salvar a mensagem no banco de dados.']);
        }
    }
    
    public function getMessages($userId, $contactId)
    {
        $messages = $this->chatModel->fetchMessages((int)$userId, (int)$contactId);
        header('Content-Type: application/json');
        echo json_encode($messages);
    }

    public function getContactList(int $currentUserId): array
    {
        // O construtor agora cuida disso
        return $this->userModel->getTodosUsuarios($currentUserId);
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
        } catch (\Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            error_log('Pusher Auth Error: ' . $e->getMessage());
            echo 'Erro ao autenticar no Pusher.';
        }
        exit();
    }
}
