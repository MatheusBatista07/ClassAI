<?php
// Inclui o autoloader do Composer, que carrega todas as bibliotecas instaladas
require_once __DIR__ . '/../vendor/autoload.php';

// Usa a biblioteca phpdotenv para carregar variáveis de ambiente
use Dotenv\Dotenv;

class Configuration {
    public static function load() {
        try {
            // Aponta para o diretório raiz do projeto (onde o .env deve estar)
            // __DIR__ . '/..' significa "a pasta pai da pasta atual (Config)"
            $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
            $dotenv->load();
        } catch (\Dotenv\Exception\InvalidPathException $e) {
            // Se o arquivo .env não for encontrado, exibe um erro mais claro
            die("Erro Crítico: Não foi possível encontrar o arquivo de configuração '.env'. Certifique-se de que o arquivo existe na raiz do projeto e tem o nome correto. Detalhe do erro: " . $e->getMessage());
        }
    }
}

// Carrega a configuração assim que este arquivo é incluído
Configuration::load();
