<?php
// Controller/ProfileController.php

class ProfileController
{
    
    private $friendModel;
    private $courseModel;
    public function __construct()
    {


        require_once 'Model/FriendModel.php';
        require_once 'Model/CourseModel.php';
        $this->friendModel = new FriendModel();
        $this->courseModel = new CourseModel();
    }

    public function index()
    {
        // Carregar a view
        require_once 'View/Pagina-perfil-amigo.php';
    }

    public function api()
    {
        // Headers para API
        header('Content-Type: application/json');

        if (!isset($_GET['action'])) {
            echo json_encode(['success' => false, 'error' => 'Nenhuma ação especificada']);
            exit;
        }

        try {
            switch ($_GET['action']) {
                case 'getFriends':
                    $friends = $this->friendModel->getAllFriends();
                    echo json_encode(['success' => true, 'data' => $friends]);
                    break;

                case 'getCourses':
                    $courses = $this->courseModel->getAllCourses();
                    echo json_encode(['success' => true, 'data' => $courses]);
                    break;

                default:
                    echo json_encode(['success' => false, 'error' => 'Ação não encontrada']);
            }
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }
}
?>