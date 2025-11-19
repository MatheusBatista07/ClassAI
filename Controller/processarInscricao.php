<?php

session_start();

$baseDir = __DIR__ . '/../';

require_once $baseDir . 'Model/Connection.php';
require_once $baseDir . 'Model/CursosModel.php';

use Model\CursosModel;

$userId = $_SESSION['usuario_id'] ?? null;
$cursoId = $_POST['curso_id'] ?? null;

if (!$userId || !$cursoId) {
    header('Location: ../View/pagina-curso.php?id=' . $cursoId . '&error=invalid_data');
    exit;
}

$cursosModel = new CursosModel();
$sucesso = $cursosModel->matricularUsuario((int)$userId, (int)$cursoId);

if ($sucesso) {
    header('Location: ../View/pagina-curso.php?id=' . $cursoId);
    exit;
} else {
    header('Location: ../View/pagina-curso.php?id=' . $cursoId . '&error=db_error');
    exit;
}
