<?php

session_start();
header('Content-Type: application/json');

function return_error($message)
{
    echo json_encode(['success' => false, 'message' => $message]);
    exit;
}

$modelPath = __DIR__ . '/Model/';
$controllerPath = __DIR__ . '/Controller/';

$required_files = [
    $modelPath . 'Connection.php',
    $modelPath . 'CursosModel.php',
    $modelPath . 'Feedback.php',
    $controllerPath . 'FeedbackController.php'
];

foreach ($required_files as $file) {
    if (!file_exists($file)) {
        error_log("Arquivo não encontrado: " . $file);
        return_error("Erro de configuração do servidor (arquivo ausente).");
    }
    require_once $file;
}

use Controller\FeedbackController;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    return_error('Método inválido.');
}

$userId = $_SESSION['usuario_id'] ?? null;
$cursoId = $_POST['curso_id'] ?? null;
$motivo = $_POST['motivo'] ?? '';

if (!$userId || !$cursoId) {
    return_error('Dados de sessão ou curso inválidos.');
}

try {
    $feedbackController = new FeedbackController();
    $sucesso = $feedbackController->handleCancelamento((int)$userId, (int)$cursoId, $motivo);

    if ($sucesso) {
        echo json_encode(['success' => true, 'message' => 'Inscrição cancelada com sucesso!']);
    } else {
        return_error('Não foi possível processar o cancelamento.');
    }
} catch (Exception $e) {
    error_log("Exceção capturada em processa-cancelamento.php: " . $e->getMessage());
    return_error("Ocorreu um erro inesperado no servidor.");
}
