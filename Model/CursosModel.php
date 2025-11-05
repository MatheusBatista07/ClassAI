<?php

use Model\Connection;

require_once __DIR__ . '/../Model/Connection.php';

class CursosModel
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function getAllCourses()
    {
        $stmt = $this->db->query("SELECT id_curso, nome_curso, prof_curso, prof_foto_url, capa_curso, dificuldade FROM cursos ORDER BY nome_curso ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInscricoesByUserId(int $userId)
    {
        $stmt = $this->db->prepare("SELECT id_curso_fk, status FROM inscricoes WHERE id_usuario_fk = ?");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    }

public function getTrendingCourses(int $limit = 3): array
{
    // VERSÃO CORRIGIDA: Busca tudo da tabela 'cursos' sem JOIN
    // e ordena pela data de criação para pegar os mais novos.
    $sql = "SELECT 
                id_curso, 
                nome_curso, 
                capa_curso, 
                prof_curso,
                prof_foto_url
            FROM 
                cursos
            ORDER BY 
                data_criacao DESC 
            LIMIT :limitVal";
    
    try {
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':limitVal', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    } catch (\PDOException $e) {
        error_log("Erro ao buscar cursos em tendência: " . $e->getMessage());
        return [];
    }
}
}
