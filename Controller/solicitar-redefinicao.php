<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Model/Connection.php';
require_once __DIR__ . '/../Model/UserModel.php';
require_once __DIR__ . '/../email_config.php'; // <<< ADICIONADO

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Model\UserModel;

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../View/pagina-login.php');
    exit;
}

$email = $_POST['userEmail'] ?? null;

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header('Location: ../View/pagina-esqueci-senha.php?status=success');
    exit;
}

$userModel = new UserModel();
$usuario = $userModel->encontrarUsuarioPorEmail($email);

if (!$usuario) {
    header('Location: ../View/pagina-esqueci-senha.php?status=success');
    exit;
}

try {
    $token = bin2hex(random_bytes(32));
    $pdo = Model\Connection::getInstance();
    $sql = "INSERT INTO password_resets (email, token) VALUES (?, ?) ON DUPLICATE KEY UPDATE token = ?, created_at = NOW()";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email, $token, $token]);
} catch (Exception $e) {
    error_log('Erro no banco de dados ao gerar token: ' . $e->getMessage());
    header('Location: ../View/pagina-esqueci-senha.php?status=error');
    exit;
}

$mail = new PHPMailer(true);

try {
    // ===== BLOCO DE CÓDIGO ATUALIZADO PARA USAR A CONFIGURAÇÃO CENTRAL =====
    $mail->isSMTP();
    $mail->Host       = SMTP_HOST;
    $mail->SMTPAuth   = true;
    $mail->Username   = SMTP_USERNAME;
    $mail->Password   = SMTP_PASSWORD;
    $mail->SMTPSecure = SMTP_SECURE;
    $mail->Port       = SMTP_PORT;
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom(FROM_EMAIL, FROM_NAME);
    // =======================================================================

    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Recuperação de Senha - ClassAI';
    $resetLink = "http://localhost/ClassAI/View/redefinir-senha.php?token=" . $token;
    $mail->Body    = "Olá!  
  
Recebemos uma solicitação para redefinir sua senha na plataforma ClassAI.  
Clique no link abaixo para criar uma nova senha:  
  
<a href='" . $resetLink . "'>Redefinir Minha Senha</a>  
  
Se você não solicitou isso, pode ignorar este e-mail.  
  
Atenciosamente,  
Equipe ClassAI";
    $mail->AltBody = 'Para redefinir sua senha, copie e cole este link no seu navegador: ' . $resetLink;

    $mail->send( );
    header('Location: ../View/pagina-esqueci-senha.php?status=success');
    exit;

} catch (Exception $e) {
    error_log("PHPMailer Error: {$mail->ErrorInfo}");
    header('Location: ../View/pagina-esqueci-senha.php?status=error');
    exit;
}
