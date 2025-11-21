<?php
namespace Controller;

use Model\CursosModel;

class CursosController
{
    private CursosModel $courseModel;

    public function __construct(CursosModel $courseModel = null)
    {
        $this->courseModel = $courseModel ?? new CursosModel();
    }

    public function getCoursesForUser()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

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
