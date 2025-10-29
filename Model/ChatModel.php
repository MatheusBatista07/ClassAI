<?php
// Model/ChatModel.php

namespace Model;

use PDO;

// ====================================================================
// A ÚNICA MUDANÇA É ADICIONAR ESTA LINHA:
// Ela garante que este arquivo saiba onde encontrar a classe 'Connection'.
require_once __DIR__ . '/Connection.php';
// ====================================================================

class ChatModel {
    private $pdo;

    public function __construct() {
        // Esta linha agora funcionará, pois o arquivo Connection.php foi incluído.
        $this->pdo = Connection::getInstance();
    }

    /**
     * Salva uma nova mensagem na tabela 'mensagens'.
     */
    public function saveMessage(int $senderId, int $receiverId, string $messageText): bool {
        $sql = "INSERT INTO mensagens (id_remetente, id_destinatario, conteudo) VALUES (?, ?, ?)";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$senderId, $receiverId, $messageText]);
            return true;
        } catch (\PDOException $e) {
            // Em um ambiente real, logue o erro: error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Busca o histórico de mensagens entre dois usuários.
     */
    public function fetchMessages(int $userId, int $contactId): array {
        // A query busca todas as mensagens onde os dois usuários são remetente ou destinatário
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
            // Em um ambiente real, logue o erro: error_log($e->getMessage());
            return []; // Retorna um array vazio em caso de erro
        }
    }

    public function getProfessores(int $excludeUserId = 0): array
{
    $sql = "SELECT id, nome, sobrenome, foto_perfil_url 
            FROM usuarios 
            WHERE funcao = 'professor' AND id != ?";
    
    try {
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$excludeUserId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
        // Em um projeto real, você deveria logar este erro.
        return []; // Retorna um array vazio se der erro.
    }
}
}
?>
