<?php

namespace Model;

require_once __DIR__ . '/../Model/Connection.php';

use PDO;
use PDOException;

class Feedback
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function saveFeedBack($message, $nome, $email)
    {
        try {
            $sql = 'INSERT INTO feedback (mensagem, nome, email) VALUES (:mensagem, :nome, :email)';
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":mensagem", $message, PDO::PARAM_STR);
            $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);

            return $stmt->execute();

        } catch (PDOException $error) {
            error_log("Erro ao enviar a mensagem: " . $error->getMessage());
            return false;
        }
    }

    public function fetchAllFeedback()
    {
        $sql = "SELECT id, nome, email, mensagem, data_envio FROM feedback ORDER BY data_envio DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function salvarFeedbackCancelamento(int $userId, int $cursoId, string $motivo): bool
    {
        $sql = "INSERT INTO feedback (id_usuario_fk, id_curso_fk, mensagem) VALUES (?, ?, ?)";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$userId, $cursoId, $motivo]);
        } catch (PDOException $e) {
            error_log("Erro ao salvar feedback de cancelamento: " . $e->getMessage());
            return false;
        }
    }
}
