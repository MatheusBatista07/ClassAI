<?php
require_once __DIR__ . '/../auth.php';
require_once __DIR__ . '/../Model/UserModel.php';

header('Content-Type: application/json');

$userId = $_SESSION['usuario_id'] ?? null;
if (!$userId) {
    echo json_encode([]); // Retorna um array vazio se não estiver logado
    exit;
}

$termo = $_GET['termo'] ?? '';

if (strlen($termo) < 2) {
    echo json_encode([]); // Não busca se o termo for muito curto
    exit;
}

try {
    $userModel = new \Model\UserModel();
    // Usamos o método que já existe no UserModel
    $resultados = $userModel->buscarNovosUsuarios($userId, $termo);
    echo json_encode($resultados);
} catch (Exception $e) {
    error_log("Erro ao buscar usuários: " . $e->getMessage());
    echo json_encode([]); // Retorna array vazio em caso de erro
}
