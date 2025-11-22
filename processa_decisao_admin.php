<?php
require_once __DIR__ . '/auth_admin.php';
require_once __DIR__ . '/Model/Connection.php';
require_once __DIR__ . '/Model/UserModel.php';
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/email_config.php'; // <<< ADICIONADO

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['aplicacao_id'], $_POST['acao'])) {
    header('Location: View/Admin/DashboardAdmin.php');
    exit;
}

$aplicacao_id = $_POST['aplicacao_id'];
$acao = $_POST['acao'];
$pdo = Model\Connection::getInstance();

$stmt = $pdo->prepare("SELECT * FROM aplicacoes_professores WHERE id = ? AND status = 'pendente'");
$stmt->execute([$aplicacao_id]);
$app = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$app) {
    header('Location: View/Admin/DashboardAdmin.php');
    exit;
}

$userModel = new \Model\UserModel();

if ($acao === 'aprovar') {
    try {
        if ($userModel->emailJaExiste($app['email'])) {
            header('Location: View/Admin/DashboardAdmin.php?status=erro_email_existente');
            exit;
        }

        $senha_temporaria = bin2hex(random_bytes(8));
        $partes_nome = explode(' ', $app['nome_completo'], 2);
        $nome = $partes_nome[0];
        $sobrenome = $partes_nome[1] ?? '';

        $dados_novo_usuario = [
            'nome' => $nome,
            'sobrenome' => $sobrenome,
            'email' => $app['email'],
            'senha' => $senha_temporaria,
            'funcao' => 'professor',
            'formacao' => $app['formacao'],
            'foto_perfil_url' => $app['caminho_foto_perfil'],
            'cpf' => null,
            'nome_usuario' => null,
            'descricao' => $app['carta_apresentacao'],
            'termos_aceitos' => true,
        ];

        $novoUsuarioId = $userModel->salvarUsuario($dados_novo_usuario);

        if ($novoUsuarioId) {
            $stmt_update = $pdo->prepare("UPDATE aplicacoes_professores SET status = 'aprovado' WHERE id = ?");
            $stmt_update->execute([$aplicacao_id]);

            // ===== BLOCO DE CÓDIGO ATUALIZADO PARA USAR A CONFIGURAÇÃO CENTRAL =====
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host       = SMTP_HOST;
                $mail->SMTPAuth   = true;
                $mail->Username   = SMTP_USERNAME;
                $mail->Password   = SMTP_PASSWORD;
                $mail->SMTPSecure = SMTP_SECURE;
                $mail->Port       = SMTP_PORT;
                $mail->CharSet    = 'UTF-8';

                $mail->setFrom(FROM_EMAIL, FROM_NAME);
                $mail->addAddress($app['email'], $app['nome_completo']);

                $mail->isHTML(true);
                $mail->Subject = 'Sua aplicação na ClassAI foi Aprovada!';
                $mail->Body    = "
                    <h1>Bem-vindo à ClassAI, Professor(a) {$nome}!</h1>
                    <p>Sua aplicação para se tornar um instrutor foi <strong>aprovada</strong>.</p>
                    <p>Credenciais para o primeiro acesso:</p>
                    <ul>
                        <li><strong>E-mail:</strong> {$app['email']}</li>
                        <li><strong>Senha Temporária:</strong> {$senha_temporaria}</li>
                    </ul>
                    <p>Recomendamos que você altere sua senha no primeiro acesso.</p>
                    <p>Atenciosamente,  
<strong>Equipe ClassAI</strong></p>
                ";
                $mail->AltBody = "Bem-vindo à ClassAI, Professor(a) {$nome}! Sua aplicação foi aprovada. Acesse com seu e-mail e a senha temporária: {$senha_temporaria}";

                $mail->send();
            } catch (Exception $e) {
                error_log("PHPMailer não pôde enviar o e-mail de aprovação. Erro: {$mail->ErrorInfo}");
            }
            // =======================================================================

            header('Location: View/Admin/DashboardAdmin.php?status=aprovado_sucesso');
            exit;
        } else {
            throw new Exception("Falha ao salvar o novo usuário.");
        }

    } catch (Exception $e) {
        error_log("Erro ao aprovar aplicação: " . $e->getMessage());
        header('Location: View/Admin/DashboardAdmin.php?status=erro_aprovacao');
        exit;
    }

} elseif ($acao === 'rejeitar') {
    $stmt_update = $pdo->prepare("UPDATE aplicacoes_professores SET status = 'rejeitado' WHERE id = ?");
    $stmt_update->execute([$aplicacao_id]);

    header('Location: View/Admin/DashboardAdmin.php?status=rejeitado_sucesso');
    exit;
}

header('Location: View/Admin/DashboardAdmin.php');
exit;
?>
