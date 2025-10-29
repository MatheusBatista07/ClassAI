<?php
// api.php

// ===================================================================
// PASSO 1: FORÇAR A EXIBIÇÃO DE TODOS OS ERROS. ESSENCIAL!
// ===================================================================
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// ===================================================================
// PASSO 2: TENTAR INCLUIR OS ARQUIVOS E VER ONDE QUEBRA
// ===================================================================
// Usamos 'require' em vez de 'require_once' no debug para garantir que ele tente carregar.
// O '@' suprime o warning padrão para que possamos capturar o erro de forma limpa.
try {
    // Tentativa de carregar o Controller. Se o caminho estiver errado, ele vai falhar aqui.
    require_once __DIR__ . '/Controller/ChatController.php';
} catch (Throwable $e) {
    // Se a inclusão falhar, o script morre aqui e mostra o erro.
    http_response_code(500 );
    header('Content-Type: application/json');
    echo json_encode([
        'status' => 'error',
        'message' => 'Falha crítica ao carregar dependências do PHP.',
        'error_details' => 'O arquivo api.php não conseguiu encontrar o ChatController.php.',
        'path_tried' => __DIR__ . '/Controller/ChatController.php',
        'exception' => $e->getMessage()
    ]);
    exit;
}

// Se chegou até aqui, o ChatController.php foi encontrado.
header('Content-Type: application/json');
$action = $_GET['action'] ?? '';

if (empty($action)) {
    http_response_code(400 );
    echo json_encode(['status' => 'error', 'message' => 'Ação não especificada.']);
    exit;
}

// ===================================================================
// PASSO 3: EXECUTAR A LÓGICA DENTRO DE UM BLOCO TRY...CATCH GIGANTE
// ===================================================================
try {
    // Agora, se o erro estiver DENTRO do ChatController (ex: ele não acha o Model),
    // este bloco vai capturar.
    $controller = new \Controller\ChatController();

    switch ($action) {
        case 'getMessages':
            $userId = $_GET['userId'] ?? 0;
            $contactId = $_GET['contactId'] ?? 0;
            
            if ($userId == 0 || $contactId == 0) {
                 http_response_code(400 );
                 echo json_encode(['status' => 'error', 'message' => 'userId e contactId são obrigatórios.']);
                 exit;
            }
            $controller->getMessages($userId, $contactId);
            break;

        case 'sendMessage':
            // ... (código do sendMessage)
            break;

        default:
            http_response_code(404 );
            echo json_encode(['status' => 'error', 'message' => 'Endpoint de ação não encontrado.']);
            break;
    }

} catch (Throwable $e) {
    // Captura qualquer erro fatal (ex: Classe 'Model\ChatModel' não encontrada) e o exibe como JSON
    http_response_code(500 );
    echo json_encode([
        'status' => 'error',
        'message' => 'Erro fatal durante a execução do controller.',
        'error_details' => [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]
    ]);
}
?>
