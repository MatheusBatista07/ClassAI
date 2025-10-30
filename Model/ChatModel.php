<?php

namespace Model;

use PDO;

require_once __DIR__ . '/Connection.php';

class ChatModel
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Connection::getInstance();
    }

    public function saveMessage(int $senderId, int $receiverId, string $messageText): bool
    {
        $sql = "INSERT INTO mensagens (id_remetente, id_destinatario, conteudo) VALUES (?, ?, ?)";
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([$senderId, $receiverId, $messageText]);
        } catch (\PDOException $e) {
            error_log("Erro ao salvar mensagem: " . $e->getMessage());
            return false;
        }
    }

    public function fetchMessages(int $userId, int $contactId): array
    {
        $sql = "SELECT id, id_remetente, conteudo, timestamp 
                FROM mensagens 
                WHERE (id_remetente = ? AND id_destinatario = ?) 
                   OR (id_remetente = ? AND id_destinatario = ?)
                ORDER BY timestamp ASC";
        
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$userId, $contactId, $contactId, $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erro ao buscar mensagens: " . $e->getMessage());
            return [];
        }
    }
}
