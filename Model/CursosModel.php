<?php

namespace Model; 

use PDO;

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
            $stmt->bindParam(':limitVal', $limit, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erro ao buscar cursos em tendência: " . $e->getMessage());
            return [];
        }
    }

    public function getCoursesByIds(array $ids) {
        if (empty($ids)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "SELECT * FROM cursos WHERE id_curso IN ($placeholders)";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute($ids);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erro ao buscar cursos por IDs com PDO: " . $e->getMessage());
            return [];
        }
    }

    public function getCourseById(int $cursoId)
    {
        $sql = "SELECT 
                    id_curso, 
                    nome_curso, 
                    descricao_curso, 
                    publico_alvo, 
                    prof_curso, 
                    prof_foto_url, 
                    capa_curso, 
                    dificuldade
                FROM cursos 
                WHERE id_curso = ?";
                
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$cursoId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erro ao buscar curso por ID: " . $e->getMessage());
            return null;
        }
    }

    public function matricularUsuario(int $userId, int $cursoId): bool
    {
        $sql = "INSERT IGNORE INTO inscricoes (id_usuario_fk, id_curso_fk, status) VALUES (?, ?, 'Em andamento')";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$userId, $cursoId]);
        } catch (\PDOException $e) {
            error_log("Erro ao matricular usuário: " . $e->getMessage());
            return false;
        }
    }

    public function cancelarMatricula(int $userId, int $cursoId): bool
    {
        $sql = "DELETE FROM inscricoes WHERE id_usuario_fk = ? AND id_curso_fk = ?";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$userId, $cursoId]);
        } catch (\PDOException $e) {
            error_log("Erro ao cancelar matrícula: " . $e->getMessage());
            return false;
        }
    }

    public function getModulosEAulasPorCursoId(int $cursoId)
    {
        $sql = "
            SELECT 
                m.id_mod, 
                m.titulo_mod,
                m.capa_mod,
                m.duracao_mod,
                COUNT(a.id_aula) AS total_aulas
            FROM 
                modulos m
            LEFT JOIN 
                aulas a ON m.id_mod = a.id_mod_fk
            WHERE 
                m.id_curso_fk = ?
            GROUP BY
                m.id_mod, m.titulo_mod, m.capa_mod, m.duracao_mod
            ORDER BY 
                m.ordem
        ";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$cursoId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (\PDOException $e) {
            error_log("Erro ao buscar módulos: " . $e->getMessage());
            return [];
        }
    }

    public function getAulaById(int $aulaId)
    {
        $sql = "SELECT id_aula, titulo_aula, video_aula, material_aula, id_mod_fk FROM aulas WHERE id_aula = ?";
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$aulaId]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erro ao buscar aula por ID: " . $e->getMessage());
            return null;
        }
    }

    public function getModuloEAulasPorId(int $modId)
    {
        $sqlModulo = "SELECT id_mod, titulo_mod, id_curso_fk FROM modulos WHERE id_mod = ?";
        $stmtModulo = $this->db->prepare($sqlModulo);
        $stmtModulo->execute([$modId]);
        $modulo = $stmtModulo->fetch(PDO::FETCH_ASSOC);

        if (!$modulo) {
            return null;
        }

        $sqlAulas = "SELECT id_aula, titulo_aula FROM aulas WHERE id_mod_fk = ? ORDER BY ordem";
        $stmtAulas = $this->db->prepare($sqlAulas);
        $stmtAulas->execute([$modId]);
        $aulas = $stmtAulas->fetchAll(PDO::FETCH_ASSOC);

        $modulo['aulas'] = $aulas;

        return $modulo;
    }
}
