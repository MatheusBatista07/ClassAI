<?php

namespace Model;    

use Model\Connection;

use PDO;
use PDOException;

class Feedback {

    private $db;

    public function __construct() {
        var_dump($this->db = Connection::getInstance());
    }

    public function saveFeedBack($message, $nome, $email) {
        $sql = 'INSERT INTO user (message, nome, email, created_at) VALUES (:message, :email, :nome, NOW())';
        
        try {
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(":message", $message, PDO::PARAM_STR);             
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