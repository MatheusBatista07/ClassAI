<?php

require_once __DIR__ . '/../vendor/autoload.php';


use Dotenv\Dotenv;

class Configuration {
    public static function load() {
        try {
           
            $dotenv = Dotenv::createImmutable(__DIR__ . '/..');
            $dotenv->load();
        } catch (\Dotenv\Exception\InvalidPathException $e) {
            
            die("Erro Crítico: Não foi possível encontrar o arquivo de configuração '.env'. Certifique-se de que o arquivo existe na raiz do projeto e tem o nome correto. Detalhe do erro: " . $e->getMessage());
        }
    }
}


Configuration::load();
