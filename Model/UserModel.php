<?php

namespace Model;

use PDO;

require_once __DIR__ . '/Connection.php';

class UserModel
{
    private $db;
    private $key;
    private $cipher;
    private static $masterPassword = 'SenhaMestraSuperSecretaDoClassAi!2025';

    public function __construct()
    {
        $this->db = Connection::getInstance();
        $this->cipher = 'aes-256-cbc';
        $this->key = hash_hkdf('sha256', self::$masterPassword, 32, 'classai-encryption-key');
    }

    public function encrypt($data)
    {
        $ivLength = openssl_cipher_iv_length($this->cipher);
        $iv = openssl_random_pseudo_bytes($ivLength);
        $encrypted = openssl_encrypt($data, $this->cipher, $this->key, 0, $iv);
        return base64_encode($iv . $encrypted);
    }

    public function decrypt($data)
    {
        $decoded = base64_decode($data);
        $ivLength = openssl_cipher_iv_length($this->cipher);
        $iv = substr($decoded, 0, $ivLength);
        $encrypted = substr($decoded, $ivLength);
        return openssl_decrypt($encrypted, $this->cipher, $this->key, 0, $iv);
    }

    public function hashCpfParaBusca($cpf)
    {
        return hash_hmac('sha256', $cpf, self::$masterPassword);
    }

    public function hashPassword($password)
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function cpfJaExiste($cpf)
    {
        $cpfHasheado = $this->hashCpfParaBusca($cpf);
        $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE cpf = ?");
        $stmt->execute([$cpfHasheado]);
        return $stmt->fetch() !== false;
    }

    public function emailJaExiste($email)
    {
        $stmt = $this->db->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch() !== false;
    }

    public function salvarUsuario($dados)
    {
        $sql = "INSERT INTO usuarios (nome, sobrenome, formacao, funcao, cpf, email, senha, nome_usuario, foto_perfil_url, descricao, termos_aceitos) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->db->prepare($sql);

        $termosAceitos = isset($dados['termos_aceitos']) && $dados['termos_aceitos'];

        $params = [
            $dados['nome'] ?? null,
            $dados['sobrenome'] ?? null,
            $dados['formacao'] ?? null,
            'aluno',
            $this->hashCpfParaBusca($dados['cpf'] ?? ''),
            $dados['email'] ?? null,
            $this->hashPassword($dados['senha'] ?? ''),
            $dados['nome_usuario'] ?? null,
            $dados['foto_perfil_url'] ?? null,
            $dados['descricao'] ?? null,
            (int)$termosAceitos
        ];

        if ($stmt->execute($params)) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    public function encontrarUsuarioPorEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTodosUsuarios(int $currentUserId): array
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
                WHERE (m.id_remetente = u.id AND m.id_destinatario = :currentUserId1) 
                   OR (m.id_remetente = :currentUserId2 AND m.id_destinatario = u.id)
                ORDER BY m.timestamp DESC 
                LIMIT 1
            ) AS ultima_mensagem,
            (
                SELECT m.timestamp 
                FROM mensagens m 
                WHERE (m.id_remetente = u.id AND m.id_destinatario = :currentUserId3) 
                   OR (m.id_remetente = :currentUserId4 AND m.id_destinatario = u.id)
                ORDER BY m.timestamp DESC 
                LIMIT 1
            ) AS timestamp_ultima_mensagem
        FROM 
            usuarios u
        WHERE 
            u.id != :currentUserId5
        ORDER BY 
            timestamp_ultima_mensagem DESC
    ";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':currentUserId1', $currentUserId, PDO::PARAM_INT);
            $stmt->bindValue(':currentUserId2', $currentUserId, PDO::PARAM_INT);
            $stmt->bindValue(':currentUserId3', $currentUserId, PDO::PARAM_INT);
            $stmt->bindValue(':currentUserId4', $currentUserId, PDO::PARAM_INT);
            $stmt->bindValue(':currentUserId5', $currentUserId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erro ao buscar lista de contatos: " . $e->getMessage());
            return [];
        }
    }

    public function encontrarUsuarioPorId(int $id)
    {
        $sql = "SELECT id, nome, sobrenome, email, funcao, foto_perfil_url, data_cadastro, status, ultimo_acesso FROM usuarios WHERE id = ?";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            error_log("Erro ao encontrar usuário por ID: " . $e->getMessage());
            return null;
        }
    }

    public function deletarUsuario(int $id): string|false
    {
        $usuario = $this->encontrarUsuarioPorId($id);
        if (!$usuario) {
            return false;
        }

        $caminhoFoto = $usuario['foto_perfil_url'];

        $stmt = $this->db->prepare("DELETE FROM usuarios WHERE id = ?");
        $sucesso = $stmt->execute([$id]);

        if ($sucesso) {
            return $caminhoFoto;
        } else {
            return false;
        }
    }

    public function atualizarStatus(int $userId, string $status): bool
    {
        $sql = "UPDATE usuarios SET status = ?, ultimo_acesso = NOW() WHERE id = ?";
        try {
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([$status, $userId]);
        } catch (\PDOException $e) {
            return false;
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

public function getInscricoesByUserId(int $userId): array
{
    $sql = "SELECT id_curso_fk, status FROM inscricoes WHERE id_usuario_fk = ?";
    try {
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
    } catch (\PDOException $e) {
        error_log("Erro ao buscar inscrições do usuário: " . $e->getMessage());
        return [];
    }
}
 
}
