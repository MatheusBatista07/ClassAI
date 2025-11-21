<?php
namespace Model;

use PDO;

require_once __DIR__ . '/Connection.php';

class AmigosModel {
    
    private $db;

    public function __construct() {
        $this->db = Connection::getInstance();
    }

    public function isFollowing($followerId, $followingId) {
        $stmt = $this->db->prepare("SELECT 1 FROM conexoes WHERE seguidor_id = ? AND seguindo_id = ?");
        $stmt->execute([$followerId, $followingId]);
        return $stmt->fetch() !== false;
    }

    public function getFollowCounts($userId) {
        $stmtFollowing = $this->db->prepare("SELECT COUNT(*) FROM conexoes WHERE seguidor_id = ?");
        $stmtFollowing->execute([$userId]);
        $followingCount = $stmtFollowing->fetchColumn();

        $stmtFollowers = $this->db->prepare("SELECT COUNT(*) FROM conexoes WHERE seguindo_id = ?");
        $stmtFollowers->execute([$userId]);
        $followersCount = $stmtFollowers->fetchColumn();

        return ['following' => $followingCount, 'followers' => $followersCount];
    }

    public function getAmigosParaChat(int $userId): array
    {
        $sql = "
            SELECT 
                u.id, 
                u.nome, 
                u.sobrenome, 
                u.foto_perfil_url, 
                u.status,
                (
                    SELECT m.conteudo 
                    FROM mensagens m 
                    WHERE (m.id_remetente = u.id AND m.id_destinatario = :userId1) 
                       OR (m.id_remetente = :userId2 AND m.id_destinatario = u.id)
                    ORDER BY m.timestamp DESC 
                    LIMIT 1
                ) AS ultima_mensagem,
                (
                    SELECT COUNT(*) 
                    FROM mensagens m 
                    WHERE m.id_remetente = u.id 
                      AND m.id_destinatario = :userId3
                      AND m.status_leitura = 'nao_lida'
                ) AS unread_count
            FROM usuarios u
            WHERE u.id != :userId4 AND (
                u.id IN (SELECT c.seguindo_id FROM conexoes c WHERE c.seguidor_id = :userId5) OR
                u.id IN (SELECT c.seguidor_id FROM conexoes c WHERE c.seguindo_id = :userId6)
            )
            ORDER BY (
                SELECT m.timestamp 
                FROM mensagens m 
                WHERE (m.id_remetente = u.id AND m.id_destinatario = :userId7) 
                   OR (m.id_remetente = :userId8 AND m.id_destinatario = u.id)
                ORDER BY m.timestamp DESC 
                LIMIT 1
            ) DESC;
        ";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':userId1', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':userId2', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':userId3', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':userId4', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':userId5', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':userId6', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':userId7', $userId, PDO::PARAM_INT);
            $stmt->bindValue(':userId8', $userId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erro ao buscar amigos para chat: " . $e->getMessage());
            return [];
        }
    }
}
