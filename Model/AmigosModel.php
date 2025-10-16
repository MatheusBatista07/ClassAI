<?php

class AmigosModel {
    private $db;

    public function __construct() {
        // Conectar ao banco
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
        $this->db = new PDO($dsn, DB_USER, DB_PASSWORD);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getAllFriends() {
        $stmt = $this->db->query("SELECT id, nome, cargo, foto_url FROM sugestoes_amigos");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>