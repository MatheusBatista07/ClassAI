<?php
header('Content-Type: application/json');

// Usar __DIR__ garante que o caminho seja sempre relativo ao arquivo atual.
require_once __DIR__ . '/Config/Configuration.php'; // Ajustado para o seu padrão
require_once __DIR__ . '/Model/Connection.php';
require_once __DIR__ . '/Model/NotificationModel.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(403 );
    echo json_encode(['error' => 'Usuário não autenticado.']);
    exit;
}

$userId = (int)$_SESSION['usuario_id'];
$action = $_GET['action'] ?? 'fetch';

try {
    $notificationModel = new \Model\NotificationModel();

    if ($_SERVER['REQUEST_METHOD'] === 'GET' && $action === 'fetch') {
        $notifications = $notificationModel->buscarNotificacoesDoUsuario($userId);
        $unreadCount = $notificationModel->contarNaoLidas($userId);
        
        echo json_encode([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);

    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'mark_all_read') {
        $success = $notificationModel->marcarTodasComoLidas($userId);
        echo json_encode(['success' => $success]);

    } else {
        http_response_code(400 );
        echo json_encode(['error' => 'Ação inválida.']);
    }
} catch (Exception $e) {
    http_response_code(500 );
    error_log("Erro na API de notificações: " . $e->getMessage());
    echo json_encode(['error' => 'Ocorreu um erro no servidor.']);
}
