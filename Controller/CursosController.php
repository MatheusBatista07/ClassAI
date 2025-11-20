<?php
namespace Controller;

use Model\CursosModel;
require_once __DIR__ . '/../Model/CursosModel.php';

class CursosController
{
    private CursosModel $courseModel; // Adicionado o tipo para boas práticas

    // O construtor agora RECEBE o CursosModel
    public function __construct(CursosModel $courseModel)
    {
        $this->courseModel = $courseModel;
    }

    public function getCoursesForUser()
    {
        // Inicia a sessão se não estiver ativa, para evitar erros nos testes
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['usuario_id'])) {
            // Lançar uma exceção é uma boa prática, pois é um erro de programação/fluxo
            throw new \Exception("Usuário não autenticado.");
        }
        $userId = $_SESSION['usuario_id'];

        $cursos = $this->courseModel->getAllCourses();
        $inscricoes = $this->courseModel->getInscricoesByUserId($userId);

        $cursosComStatus = [];
        foreach ($cursos as $curso) {
            // Adiciona o status ao curso, usando 'Disponível' como padrão
            $curso['status'] = $inscricoes[$curso['id_curso']] ?? 'Disponível';
            $cursosComStatus[] = $curso;
        }

        return $cursosComStatus;
    }
}
?>