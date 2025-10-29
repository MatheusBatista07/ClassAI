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

        // Pega o valor de 'termos_aceitos' do array de dados. Se não existir, assume 'false'.
        $termosAceitos = isset($dados['termos_aceitos']) && $dados['termos_aceitos'];

        // Prepara os dados para a execução, garantindo que 'termos_aceitos' seja 0 ou 1.
        $params = [
            $dados['nome'] ?? null,
            $dados['sobrenome'] ?? null,
            $dados['formacao'] ?? null,
            'aluno', // Define a função padrão como 'aluno'
            $this->hashCpfParaBusca($dados['cpf'] ?? ''),
            $dados['email'] ?? null,
            $this->hashPassword($dados['senha'] ?? ''),
            $dados['nome_usuario'] ?? null,
            $dados['foto_perfil_url'] ?? null,
            $dados['descricao'] ?? null,
            // =======================================================
            // A CORREÇÃO ESTÁ AQUI:
            // Converte o valor booleano (true/false) para um inteiro (1/0).
            // =======================================================
            (int)$termosAceitos
        ];

        // A linha 76 agora receberá os parâmetros corretamente formatados.
        return $stmt->execute($params);
    }

    public function encontrarUsuarioPorEmail($email)
    {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Busca todos os usuários cadastrados no sistema, exceto o próprio usuário logado.
     *
     * @param int $excludeUserId O ID do usuário logado, para não aparecer na própria lista.
     * @return array Uma lista com todos os outros usuários.
     */
    public function getTodosUsuarios(int $excludeUserId): array
    {
        // A consulta agora busca todos os usuários, sem filtrar pela função.
        // Adicionamos a coluna 'funcao' ao SELECT para uso futuro na View.
        $sql = "SELECT id, nome, sobrenome, foto_perfil_url, funcao 
                FROM usuarios 
                WHERE id != ?";

        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$excludeUserId]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            // Em um ambiente de produção, seria bom logar o erro.
            // error_log("Erro ao buscar todos os usuários: " . $e->getMessage());
            return []; // Retorna um array vazio para evitar que a aplicação quebre.
        }
    }
}
