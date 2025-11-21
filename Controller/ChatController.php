<?php

namespace Controller;

use Model\ChatModel;
use Model\UserModel;
use Model\NotificationModel;
use Model\AmigosModel;
use Pusher\Pusher;
use Pusher\PusherException;

class ChatController
{
    private $pusher;
    private $chatModel;
    private $userModel;
    private $notificationModel;
    private $amigosModel;

    public function __construct(
        ChatModel $chatModel = null,
        UserModel $userModel = null,
        NotificationModel $notificationModel = null,
        AmigosModel $amigosModel = null,
        Pusher $pusher = null
    ) {
        require_once __DIR__ . '/../Config/Configuration.php';

        $this->chatModel = $chatModel ?? new ChatModel();
        $this->userModel = $userModel ?? new UserModel();
        $this->notificationModel = $notificationModel ?? new NotificationModel();
        $this->amigosModel = $amigosModel ?? new AmigosModel();

        if ($pusher) {
            $this->pusher = $pusher;
        } else {
            try {
                $this->pusher = new Pusher(PUSHER_APP_KEY, PUSHER_APP_SECRET, PUSHER_APP_ID, ['cluster' => PUSHER_APP_CLUSTER, 'useTLS' => true]);
            } catch (PusherException $e) {
                error_log("Erro ao conectar com o Pusher: " . $e->getMessage());
            }
        }
    }

    public function sendMessage()
    {
        date_default_timezone_set('America/Sao_Paulo');
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['senderId'], $data['receiverId'], $data['message'])) {
            http_response_code(400);
            echo json_encode(['status' => 'error', 'message' => 'Dados incompletos.']);
            return;
        }

        $senderId = (int) $data['senderId'];
        $receiverId = (int) $data['receiverId'];
        $messageText = htmlspecialchars($data['message']);

        if ($this->chatModel->saveMessage($senderId, $receiverId, $messageText)) {
            $chatChannel = 'private-chat-user-' . $receiverId;
            $chatPayload = [
                'senderId' => $senderId,
                'receiverId' => $receiverId,
                'message' => $messageText,
                'timestamp' => date('Y-m-d H:i:s')
            ];
            $socketId = $data['socket_id'] ?? null;
            if ($this->pusher) {
                $this->pusher->trigger($chatChannel, 'new-message', $chatPayload, ['socket_id' => $socketId]);
            }

            $senderInfo = $this->userModel->encontrarUsuarioPorId($senderId);
            $senderName = $senderInfo ? $senderInfo['nome'] : 'Alguém';

            $notificationMessage = "Você tem uma nova mensagem de {$senderName}.";
            $notificationLink = "paginaChat.php?contactId={$senderId}";

            $this->notificationModel->criarNotificacao($receiverId, 'nova_mensagem', $notificationMessage, $senderId, $notificationLink);

            $notificationChannel = 'notifications-user-' . $receiverId;
            $notificationPayload = ['message' => $notificationMessage, 'link' => $notificationLink];
            if ($this->pusher) {
                $this->pusher->trigger($notificationChannel, 'new-notification', $notificationPayload);
            }

            echo json_encode(['status' => 'success', 'message' => 'Mensagem enviada.']);
        } else {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Falha ao salvar a mensagem no banco de dados.']);
        }
    }

    public function getMessages($userId, $contactId)
    {
        $messages = $this->chatModel->fetchMessages((int) $userId, (int) $contactId);
        header('Content-Type: application/json');
        echo json_encode($messages);
    }

    public function getContactList(int $currentUserId): array
    {
        return $this->amigosModel->getAmigosParaChat($currentUserId);
    }

    public function pusherAuth()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id'])) {
            header('HTTP/1.1 403 Forbidden');
            exit('Acesso negado.');
        }

        $socketId = $_POST['socket_id'] ?? '';
        $channelName = $_POST['channel_name'] ?? '';

        if (empty($socketId) || empty($channelName)) {
            header('HTTP/1.1 400 Bad Request');
            exit('socket_id e channel_name são obrigatórios.');
        }

        $userId = $_SESSION['usuario_id'];
        $userInfo = [
            'nome' => $_SESSION['usuario_nome'] ?? 'Anônimo',
            'foto_url' => $_SESSION['usuario_foto_url'] ?? null
        ];

        try {
            if ($this->pusher) {
                $auth = $this->pusher->authorizePresenceChannel($channelName, $socketId, $userId, $userInfo);
                header('Content-Type: application/json');
                echo $auth;
            }
        } catch (\Exception $e) {
            header('HTTP/1.1 500 Internal Server Error');
            error_log('Pusher Auth Error: ' . $e->getMessage());
            echo 'Erro ao autenticar no Pusher.';
        }
        exit();
    }
}

$action = $_GET['action'] ?? null;

if ($action) {
    require_once __DIR__ . '/../auth.php';
    require_once __DIR__ . '/../vendor/autoload.php';
    require_once __DIR__ . '/../Model/ChatModel.php';
    require_once __DIR__ . '/../Model/UserModel.php';
    require_once __DIR__ . '/../Model/NotificationModel.php';
    require_once __DIR__ . '/../Model/AmigosModel.php';

    $controller = new \Controller\ChatController();

    switch ($action) {
        case 'getMessages':
            $userId = $_GET['userId'] ?? null;
            $contactId = $_GET['contactId'] ?? null;
            if ($userId && $contactId) {
                $controller->getMessages($userId, $contactId);
            }
            break;

        case 'sendMessage':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller->sendMessage();
            }
            break;
    }
}
