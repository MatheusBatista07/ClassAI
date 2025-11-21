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

// Cole esta função corrigida no lugar da antiga em Model/ChatModel.php

public function getRecentConversations(int $userId, int $limit = 4): array
{
    $sql = "
        SELECT 
            u.id AS contact_id,
            u.nome,
            u.sobrenome,
            u.foto_perfil_url,
            m.conteudo AS ultima_mensagem,
            m.timestamp,
            m.status_leitura, -- <<< CORREÇÃO APLICADA AQUI
            m.id_remetente
        FROM mensagens m
        JOIN (
            SELECT 
                GREATEST(id_remetente, id_destinatario) as user1,
                LEAST(id_remetente, id_destinatario) as user2,
                MAX(id) as last_message_id
            FROM mensagens
            WHERE id_remetente = :userId OR id_destinatario = :userId
            GROUP BY user1, user2
        ) AS lm ON m.id = lm.last_message_id
        JOIN usuarios u ON u.id = IF(m.id_remetente = :userId, m.id_destinatario, m.id_remetente)
        ORDER BY m.timestamp DESC
        LIMIT :limitVal;
    ";

    try {
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->bindParam(':limitVal', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
        error_log("Erro ao buscar conversas recentes: " . $e->getMessage());
        return [];
    }
}

public function markMessagesAsRead(int $userId, int $contactId): bool
{
    $sql = "UPDATE mensagens 
            SET status_leitura = 'lida' 
            WHERE id_destinatario = ? AND id_remetente = ? AND status_leitura = 'nao_lida'";
    try {
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([$userId, $contactId]);
    } catch (\PDOException $e) {
        error_log("Erro ao marcar mensagens como lidas: " . $e->getMessage());
        return false;
    }
}

}
