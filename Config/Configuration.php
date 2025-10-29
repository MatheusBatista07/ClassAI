<?php
// Config/Configuration.php

// --- CONFIGURAÇÃO DO BANCO DE DADOS ---
// Verifique se a porta é necessária. Se for a padrão (3306), pode remover.
define('DB_HOST', 'localhost');
define('DB_PORT', '3306'); 
define('DB_NAME', 'classai'); // O nome do seu banco de dados
define('DB_USER', 'root');
define('DB_PASSWORD', ''); // Sua senha do MySQL (geralmente vazia no XAMPP/WAMP)

// --- CONFIGURAÇÃO DA API DO PUSHER ---
// Substitua pelos valores REAIS do seu painel no Pusher
define('PUSHER_APP_ID', '2069901');
define('PUSHER_APP_KEY', '7c0e3086c3a3afbb1b08');       // <-- COPIE E COLE A 'Key' DA PÁGINA DO PUSHER
define('PUSHER_APP_SECRET', '228a0aa864d9ae8d5d3b');  // <-- COPIE E COLE O 'Secret' DA PÁGINA DO PUSHER
define('PUSHER_APP_CLUSTER', 'us2'); // <-- COPIE E COLE O 'Cluster' (ex: 'us2')
?>
