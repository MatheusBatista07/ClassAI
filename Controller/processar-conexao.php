<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../Model/UserModel.php';
require_once __DIR__ . '/../Model/AmigosModel.php';

function responderJson($data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    responderJson(['status' => 'error', 'message' => 'Método não permitido.']);
}

$meuId = $_SESSION['usuario_id'] ?? null;
$alvoId = $_POST['alvo_id'] ?? null;
$acao = $_POST['acao'] ?? null;

if (!$meuId) {
    responderJson(['status' => 'error', 'message' => 'Usuário não autenticado.']);
}
if (!$alvoId || !$acao) {
    responderJson(['status' => 'error', 'message' => 'Dados incompletos.']);
}
if ($meuId == $alvoId) {
    responderJson(['status' => 'error', 'message' => 'Você não pode seguir a si mesmo.']);
}

try {
    $userModel = new \Model\UserModel();
    $amigosModel = new \Model\AmigosModel();
    $sucesso = false;

    if ($acao === 'seguir') {
        $sucesso = $userModel->seguirUsuario($meuId, $alvoId);
    } elseif ($acao === 'deixar_de_seguir') {
        $sucesso = $userModel->deixarDeSeguirUsuario($meuId, $alvoId);
    } else {
        responderJson(['status' => 'error', 'message' => 'Ação desconhecida.']);
    }

    if ($sucesso) {
        $contagens = $amigosModel->getFollowCounts($alvoId);
        $novaContagem = $contagens['followers'];

        responderJson([
            'status' => 'success',
            'message' => 'Ação executada com sucesso.',
            'novaContagemSeguidores' => $novaContagem
        ]);
    } else {
        responderJson(['status' => 'error', 'message' => 'Não foi possível completar a ação.']);
    }

} catch (Exception $e) {
    error_log("Erro em processar-conexao.php: " . $e->getMessage());
    responderJson(['status' => 'error', 'message' => 'Ocorreu um erro no servidor.']);
}
