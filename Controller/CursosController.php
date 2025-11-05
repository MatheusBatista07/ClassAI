<?php
if (!class_exists('CursoController')) {
    class CursoController
    {
        private $courseModel;

        public function __construct()
        {
            require_once 'Model/Cursos.php';
            $this->courseModel = new CursosModel();
        }

        public function api()
        {
            header('Content-Type: application/json');

            if (!isset($_GET['action'])) {
                echo json_encode(['success' => false, 'error' => 'Nenhuma ação de curso especificada']);
                return;
            }

            try {
                switch ($_GET['action']) {
                    case 'getCourses':
                        $courses = $this->courseModel->getAllCourses();
                        echo json_encode(['success' => true, 'data' => $courses]);
                        break;

                    default:
                        echo json_encode(['success' => false, 'error' => 'Ação de curso não encontrada']);
                }
            } catch (Exception $e) {
                http_response_code(500 );
                echo json_encode(['success' => false, 'error' => 'Erro no servidor: ' . $e->getMessage()]);
            }
        }
    }
}
?>