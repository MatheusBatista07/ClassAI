<?php

namespace Model;

use PDO;

class NotificationModel
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function criarNotificacao(int $idUsuarioDestino, string $tipo, string $mensagem, ?int $idOrigem = null, ?string $link = null): bool
    {
        $sql = "INSERT INTO notificacoes (id_usuario_destino, tipo, mensagem, id_origem, link) 
                VALUES (?, ?, ?, ?, ?)";
        
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$idUsuarioDestino, $tipo, $mensagem, $idOrigem, $link]);
        } catch (\PDOException $e) {
            error_log("Erro ao criar notificação: " . $e->getMessage());
            return false;
        }
    }

    public function buscarNotificacoesDoUsuario(int $idUsuario, int $limite = 10): array
    {
        $sql = "SELECT id, tipo, mensagem, link, lida, data_criacao 
                FROM notificacoes 
                WHERE id_usuario_destino = ? 
                ORDER BY data_criacao DESC 
                LIMIT ?";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(1, $idUsuario, PDO::PARAM_INT);
            $stmt->bindParam(2, $limite, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erro ao buscar notificações: " . $e->getMessage());
            return [];
        }
    }

    public function contarNaoLidas(int $idUsuario): int
    {
        $sql = "SELECT COUNT(id) FROM notificacoes WHERE id_usuario_destino = ? AND lida = 0";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$idUsuario]);
            return (int) $stmt->fetchColumn();
        } catch (\PDOException $e) {
            error_log("Erro ao contar notificações não lidas: " . $e->getMessage());
            return 0;
        }
    }

    public function marcarTodasComoLidas(int $idUsuario): bool
    {
        $sql = "UPDATE notificacoes SET lida = 1 WHERE id_usuario_destino = ? AND lida = 0";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$idUsuario]);
        } catch (\PDOException $e) {
            error_log("Erro ao marcar notificações como lidas: " . $e->getMessage());
            return false;
        }
    }
}
