<?php

namespace Controller;

use Model\Feedback;
use Model\CursosModel;
use Exception;

class FeedbackController
{
    private Feedback $feedbackModel;
    private CursosModel $cursosModel;

    public function __construct(Feedback $feedbackModel = null, CursosModel $cursosModel = null)
    {
        $this->feedbackModel = $feedbackModel;
        $this->cursosModel = $cursosModel;
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

            // Tenta cancelar a matrícula
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
}