<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../Model/UserModel.php';

// Função auxiliar para enviar respostas JSON padronizadas
function responderJson($status, $message) {
    header('Content-Type: application/json');
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

// Verifica se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responderJson('error', 'Método não permitido.');
}

// Pega os dados enviados pelo JavaScript
$meuId = $_SESSION['usuario_id'] ?? null;
$alvoId = $_POST['alvo_id'] ?? null;
$acao = $_POST['acao'] ?? null;

// Validações básicas
if (!$meuId) {
    responderJson('error', 'Usuário não autenticado.');
}
if (!$alvoId || !$acao) {
    responderJson('error', 'Dados incompletos.');
}
if ($meuId == $alvoId) {
    responderJson('error', 'Você não pode seguir a si mesmo.');
}

try {
    $userModel = new \Model\UserModel();
    $sucesso = false;

    // Executa a ação com base no que o JavaScript enviou
    if ($acao === 'seguir') {
        $sucesso = $userModel->seguirUsuario($meuId, $alvoId);
    } elseif ($acao === 'deixar_de_seguir') {
        $sucesso = $userModel->deixarDeSeguirUsuario($meuId, $alvoId);
    } else {
        responderJson('error', 'Ação desconhecida.');
    }

    // Responde ao JavaScript
    if ($sucesso) {
        responderJson('success', 'Ação executada com sucesso.');
    } else {
        responderJson('error', 'Não foi possível completar a ação.');
    }

} catch (Exception $e) {
    // Em caso de erro no banco de dados ou outro problema
    error_log("Erro em processar-conexao.php: " . $e->getMessage());
    responderJson('error', 'Ocorreu um erro no servidor.');
}
