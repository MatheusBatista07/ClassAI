<?php
namespace Model;

use PDO;

// Inclui o arquivo de conexão, assim como o UserModel faz.
require_once __DIR__ . '/Connection.php';

class AmigosModel {
    
    private $db;

    public function __construct() {
        // Pega a instância da conexão com o banco de dados.
        $this->db = Connection::getInstance();
    }

    /**
     * Verifica se um usuário já segue outro.
     */
    public function isFollowing($followerId, $followingId) {
        $stmt = $this->db->prepare("SELECT 1 FROM conexoes WHERE seguidor_id = ? AND seguindo_id = ?");
        $stmt->execute([$followerId, $followingId]);
        return $stmt->fetch() !== false;
    }

    /**
     * Retorna a contagem de 'seguindo' e 'seguidores' de um usuário.
     */
    public function getFollowCounts($userId) {
        // Contar quantos o usuário SEGUE
        $stmtFollowing = $this->db->prepare("SELECT COUNT(*) FROM conexoes WHERE seguidor_id = ?");
        $stmtFollowing->execute([$userId]);
        $followingCount = $stmtFollowing->fetchColumn();

        // Contar quantos SEGUEM o usuário
        $stmtFollowers = $this->db->prepare("SELECT COUNT(*) FROM conexoes WHERE seguindo_id = ?");
        $stmtFollowers->execute([$userId]);
        $followersCount = $stmtFollowers->fetchColumn();

        return ['following' => $followingCount, 'followers' => $followersCount];
    }
}
