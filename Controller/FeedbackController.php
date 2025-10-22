<?php

namespace Controller;

use Model\Feedback;
use Exception;

class FeedbackController {

    private $feedbackModel;

    public function __construct()
    {
        $this->feedbackModel = new Feedback();
    }

    public function submitMessage($message, $nome, $email)
    {
        try {
            if(empty($message) or empty($nome) or empty($email)) {
                throw new Exception("Todos os campos são obrigatórios.");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("O formato do e-mail é inválido.");
            }

            $success = $this->feedbackModel->saveFeedBack($nome, $email, $message);

            return $success;
        } catch (Exception $error) { 
            error_log("Erro em ao enviar mensagem " . $error->getMessage());
            return false; 
        }
    }

}

?>