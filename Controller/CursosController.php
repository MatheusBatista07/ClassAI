<?php
namespace Controller;

use Model\CursosModel;
require_once __DIR__ . '/../Model/CursosModel.php';

class CursosController
{
    private $courseModel;

    public function __construct()
    {
        $this->courseModel = new CursosModel();
    }

    public function getCoursesForUser()
    {
        if (!isset($_SESSION['usuario_id'])) {
            throw new \Exception("Usuário não autenticado.");
        }
        $userId = $_SESSION['usuario_id'];

        $cursos = $this->courseModel->getAllCourses();
        $inscricoes = $this->courseModel->getInscricoesByUserId($userId);

        $cursosComStatus = [];
        foreach ($cursos as $curso) {
            $curso['status'] = $inscricoes[$curso['id_curso']] ?? 'Disponível';
            $cursosComStatus[] = $curso;
        }

        return $cursosComStatus;
    }
}
?>
