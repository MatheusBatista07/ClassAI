<?php

namespace Controller;

use Model\Feedback;
use Model\CursosModel;
use Exception;

class FeedbackController
{
    private $feedbackModel;
    private $cursosModel;

    public function __construct()
    {
        $this->feedbackModel = new Feedback();
        $this->cursosModel = new CursosModel();
    }

    public function submitMessage($message, $nome, $email)
    {
        try {
            if (empty($message) || empty($nome) || empty($email)) {
                throw new Exception("Todos os campos são obrigatórios.");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("O formato do e-mail é inválido.");
            }

            return $this->feedbackModel->saveFeedBack($message, $nome, $email);

        } catch (Exception $error) {
            error_log("Erro ao enviar mensagem: " . $error->getMessage());
            return false;
        }
    }

    public function handleCancelamento(int $userId, int $cursoId, string $motivo = '')
    {
        try {
            if (!empty(trim($motivo))) {
                $this->feedbackModel->salvarFeedbackCancelamento($userId, $cursoId, $motivo);
            }

            $sucessoCancelamento = $this->cursosModel->cancelarMatricula($userId, $cursoId);

            if (!$sucessoCancelamento) {
                throw new Exception("Falha ao cancelar a matrícula no Model.");
            }

            return true;

        } catch (Exception $e) {
            error_log("Erro no handleCancelamento: " . $e->getMessage());
            return false;
        }
    }

    public function handleFormSubmission()
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            header('Location: index.php');
            exit;
        }

        $message = $_POST["mensagem"] ?? '';
        $email = $_POST["email"] ?? '';
        $nome = $_POST["nome"] ?? '';

        if ($this->submitMessage($message, $nome, $email)) {
            echo "<script>alert('Mensagem enviada com sucesso'); window.location.href = 'index.php';</script>";
        } else {
            echo "<script>alert('Falha ao enviar mensagem. Verifique os campos.'); window.history.back();</script>";
        }
        exit;
    }
}
