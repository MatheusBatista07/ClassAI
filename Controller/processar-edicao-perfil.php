<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../Model/UserModel.php';

header('Content-Type: application/json');

function responderJson($status, $message, $extraData = []) {
    echo json_encode(array_merge(['status' => $status, 'message' => $message], $extraData));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responderJson('error', 'Método não permitido.');
}

$userId = $_SESSION['usuario_id'] ?? null;
if (!$userId) {
    responderJson('error', 'Usuário não autenticado. Faça login novamente.');
}

$nome = trim($_POST['nome'] ?? '');
$sobrenome = trim($_POST['sobrenome'] ?? '');

if (empty($nome) || empty($sobrenome)) {
    responderJson('error', 'Nome e sobrenome não podem estar vazios.');
}

try {
    $userModel = new \Model\UserModel();
    $sucesso = $userModel->atualizarPerfilUsuario($userId, $nome, $sobrenome);

    if ($sucesso) {
        $novoNomeCompleto = $nome . ' ' . $sobrenome;
        responderJson('success', 'Perfil atualizado com sucesso!', ['novoNomeCompleto' => $novoNomeCompleto]);
    } else {
        responderJson('error', 'Não foi possível atualizar o perfil. Tente novamente.');
    }
} catch (Exception $e) {
    error_log("Erro no controller ao processar edição de perfil: " . $e->getMessage());
    responderJson('error', 'Ocorreu um erro inesperado no servidor.');
}
