<?php
// Model/ChatModel.php

namespace Model;

use PDO;

// Garante que a classe de Conexão seja carregada
require_once __DIR__ . '/Connection.php';

class ChatModel
{
    // 1. CORREÇÃO: A propriedade se chama 'pdo' em todo o arquivo para consistência.
    private $pdo;

    public function __construct()
    {
        $this->pdo = Connection::getInstance();
    }

    /**
     * Salva uma nova mensagem na tabela 'mensagens'.
     * Verifique se os nomes das colunas 'id_remetente', 'id_destinatario', 'conteudo'
     * correspondem exatamente ao seu banco de dados.
     */
    public function saveMessage(int $senderId, int $receiverId, string $messageText): bool
    {
        $sql = "INSERT INTO mensagens (id_remetente, id_destinatario, conteudo) VALUES (?, ?, ?)";
        try {
            $stmt = $this->pdo->prepare($sql); // Usa $this->pdo
            return $stmt->execute([$senderId, $receiverId, $messageText]);
        } catch (\PDOException $e) {
            // Em um ambiente real, logue o erro: error_log($e->getMessage());
            return false;
        }
    }

    /**
     * Busca o histórico de mensagens entre dois usuários.
     * Verifique se os nomes das colunas 'id_remetente', 'id_destinatario', 'conteudo', 'data_envio'
     * correspondem exatamente ao seu banco de dados.
     */
    public function fetchMessages(int $userId, int $contactId): array
    {
        // Renomeei a coluna 'timestamp' para 'data_envio' para corresponder ao padrão do Pusher.
        // Se no seu banco for 'timestamp', troque de volta.
        $sql = "SELECT id, id_remetente, conteudo, data_envio 
                FROM mensagens 
                WHERE (id_remetente = ? AND id_destinatario = ?) 
                   OR (id_remetente = ? AND id_destinatario = ?)
                ORDER BY data_envio ASC";
        
        try {
            $stmt = $this->pdo->prepare($sql); // Usa $this->pdo
            $stmt->execute([$userId, $contactId, $contactId, $userId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Em um ambiente real, logue o erro: error_log($e->getMessage());
            return []; // Retorna um array vazio em caso de erro
        }
    }

    // 2. REMOÇÃO: O método getProfessores foi removido daqui.
    // Seu lugar correto é no UserModel, onde ele já existe (como getTodosUsuarios).
}
?>
