<?php

namespace Model;    

require_once __DIR__ . '/../Model/Connection.php';
require_once __DIR__ . '/../Model/Feedback.php';  


use Model\Connection;

use PDO;
use PDOException;

class Feedback {

    private $db;

    public function __construct() {
        $this->db = Connection::getInstance();
    }

    public function saveFeedBack($message, $nome, $email) {
        
        try {
            $sql = 'INSERT INTO feedback (mensagem, nome, email, data_envio) VALUES (:mensagem, :email, :nome, NOW())';
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":mensagem", $message, PDO::PARAM_STR);             
            $stmt->bindParam(":nome", $nome, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);

            return $stmt->execute();

        } catch(PDOException $error) {
            echo "Error ao enviar a mensagem" . $error->getMessage();
            return false;
        }
    }

    public function fetchAllFeedback()
    {
        $sql = "SELECT id, nome, email, mensagem, data_envio FROM feedback ORDER BY data_envio DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }
}
?>