<?php

use Model\CursosModel;
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../Model/CursosModel.php';

header('Content-Type: application/json');

$input = json_decode(file_get_contents('php://input'), true);
$cursoId = $input['curso_id'] ?? null;
$acao = $input['acao'] ?? null;
$userId = $_SESSION['usuario_id'];

if (!$cursoId || !$acao) {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
    exit;
}

$cursosModel = new CursosModel();
$success = false;
$message = '';

try {
    if ($acao === 'matricular') {
        $success = $cursosModel->matricularUsuario($userId, $cursoId);
        $message = $success ? 'Matrícula realizada com sucesso!' : 'Falha ao realizar matrícula.';
    } elseif ($acao === 'cancelar') {
        $success = $cursosModel->cancelarMatricula($userId, $cursoId);
        $message = $success ? 'Matrícula cancelada com sucesso!' : 'Falha ao cancelar matrícula.';
    } else {
        $message = 'Ação desconhecida.';
    }
} catch (Exception $e) {
    $success = false;
    $message = 'Ocorreu um erro no servidor: ' . $e->getMessage();
    error_log($message);
}

echo json_encode(['success' => $success, 'message' => $message]);
