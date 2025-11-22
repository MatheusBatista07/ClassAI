<?php
session_start();
require_once __DIR__ . '/Model/Connection.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: View/TorneSeProfessor.php');
    exit;
}

function set_feedback_and_redirect($status, $message) {
    $_SESSION['feedback'] = ['status' => $status, 'message' => $message];
    header('Location: View/TorneSeProfessor.php');
    exit;
}

$nome = $_POST['nome_completo'] ?? '';
$email = $_POST['email'] ?? '';
$formacao = $_POST['formacao'] ?? '';
$link_portfolio = $_POST['link_portfolio'] ?? '';
$carta = $_POST['carta_apresentacao'] ?? '';
$telefone = $_POST['telefone'] ?? null;
$caminho_foto = null;

if (empty($nome) || empty($email) || empty($formacao) || empty($link_portfolio) || empty($carta)) {
    set_feedback_and_redirect('error', 'Todos os campos obrigatórios devem ser preenchidos.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    set_feedback_and_redirect('error', 'O e-mail fornecido não é válido.');
}

if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] === UPLOAD_ERR_OK) {
    $foto = $_FILES['foto_perfil'];
    $allowed_image_types = ['image/jpeg', 'image/png', 'image/gif'];

    if (in_array($foto['type'], $allowed_image_types)) {
        $pasta_fotos = __DIR__ . '/public/uploads/perfil_aplicacoes/';
        if (!is_dir($pasta_fotos)) {
            mkdir($pasta_fotos, 0775, true);
        }

        $nome_foto = uniqid('foto_', true) . '_' . basename($foto['name']);
        $destino_foto = $pasta_fotos . $nome_foto;

        if (move_uploaded_file($foto['tmp_name'], $destino_foto)) {
            $caminho_foto = 'public/uploads/perfil_aplicacoes/' . $nome_foto;
        }
    }
}

if (!isset($_FILES['curriculo']) || $_FILES['curriculo']['error'] !== UPLOAD_ERR_OK) {
    set_feedback_and_redirect('error', 'Ocorreu um erro com o upload do currículo. Tente novamente.');
}

$curriculo = $_FILES['curriculo'];
$allowed_types = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
if (!in_array($curriculo['type'], $allowed_types)) {
    set_feedback_and_redirect('error', 'Formato de currículo inválido. Apenas PDF, DOC e DOCX são permitidos.');
}

$pasta_uploads = __DIR__ . '/public/uploads/curriculos/';
if (!is_dir($pasta_uploads)) {
    mkdir($pasta_uploads, 0775, true);
}

$nome_arquivo = uniqid('curriculo_', true) . '_' . basename($curriculo['name']);
$caminho_destino = $pasta_uploads . $nome_arquivo;

if (!move_uploaded_file($curriculo['tmp_name'], $caminho_destino)) {
    set_feedback_and_redirect('error', 'Não foi possível salvar o arquivo do currículo.');
}

$caminho_banco = 'public/uploads/curriculos/' . $nome_arquivo;

$pdo = Model\Connection::getInstance();

try {
    $stmt_check = $pdo->prepare("SELECT id FROM aplicacoes_professores WHERE email = ?");
    $stmt_check->execute([$email]);
    if ($stmt_check->fetch()) {
        set_feedback_and_redirect('error', 'Este e-mail já foi utilizado em uma aplicação.');
    }

    $sql = "INSERT INTO aplicacoes_professores (nome_completo, email, telefone, formacao, link_portfolio, caminho_foto_perfil, carta_apresentacao, caminho_curriculo) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nome, $email, $telefone, $formacao, $link_portfolio, $caminho_foto, $carta, $caminho_banco]);

    set_feedback_and_redirect('success', 'Aplicação enviada com sucesso! Entraremos em contato em breve.');

} catch (PDOException $e) {
    error_log('Erro ao salvar aplicação: ' . $e->getMessage());
    set_feedback_and_redirect('error', 'Ocorreu um erro interno ao processar sua aplicação. Por favor, tente mais tarde.');
}
?>
