<?php
// index.php (CORRIGIDO)

// Define uma constante para o caminho base da aplicação.
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME'] ));
define('ROOT_PATH', __DIR__ . '/'); // Define o caminho absoluto da raiz do projeto

// Use o caminho absoluto para incluir o Controller
require_once ROOT_PATH . 'Controller/UserController.php';

$controller = new UserController();
$controller->index();
