<?php
if (!class_exists('AmigoController')) {
    class AmigoController
    {
        private $friendModel;

        public function __construct()
        {
            require_once 'Model/Amigos.php';
            $this->friendModel = new AmigosModel();
        }

        public function api()
        {
            header('Content-Type: application/json');

            if (!isset($_GET['action'])) {
                echo json_encode(['success' => false, 'error' => 'Nenhuma ação de amigo especificada']);
                return;
            }

            try {
                switch ($_GET['action']) {
                    case 'getFriends':
                        $friends = $this->friendModel->getAllFriends();
                        echo json_encode(['success' => true, 'data' => $friends]);
                        break;

                    default:
                        echo json_encode(['success' => false, 'error' => 'Ação de amigo não encontrada']);
                }
            } catch (Exception $e) {
                http_response_code(500 );
                echo json_encode(['success' => false, 'error' => $e->getMessage()]);
            }
        }
    }
}
?>
