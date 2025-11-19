<?php

define('ROOT_PATH', __DIR__);


$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];
$script_name = str_replace('index.php', '', $_SERVER['SCRIPT_NAME'] );
define('BASE_URL', $protocol . "://" . $host . $script_name);


require_once ROOT_PATH . '/Config/Configuration.php';
require_once ROOT_PATH . '/Controller/UserController.php';

$view = $_GET['view'] ?? null;
$action = $_GET['action'] ?? null;

$userController = new UserController();

if ($action === 'askLazo') {
    $userController->askLazo();
    exit;
}

if ($view === 'lazoai') {
    require_once ROOT_PATH . '/View/lazoai.php';
} else {
 
    require_once ROOT_PATH . '/View/lazoai.php';
}
