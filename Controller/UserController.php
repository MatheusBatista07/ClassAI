<?php

class UserController {
    // ... seus outros métodos ...

    /**
     * Recebe uma requisição AJAX para curtir ou descurtir um curso.
     */
    public function toggleLike() {
        // Garante que a requisição é um POST e é AJAX
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SERVER['HTTP_X_REQUESTED_WITH'])) {
            http_response_code(405 ); // Method Not Allowed
            echo json_encode(['success' => false, 'message' => 'Método não permitido.']);
            return;
        }

        // Pega os dados enviados pelo JavaScript
        $data = json_decode(file_get_contents('php://input'), true);

        // Validação básica dos dados
        if (!isset($_SESSION['user_id']) || !isset($data['course_id'])) {
            http_response_code(400 ); // Bad Request
            echo json_encode(['success' => false, 'message' => 'Dados incompletos ou usuário não logado.']);
            return;
        }

        $userId = $_SESSION['user_id'];
        $courseId = filter_var($data['course_id'], FILTER_SANITIZE_NUMBER_INT);
        $isLiked = filter_var($data['liked'], FILTER_VALIDATE_BOOLEAN);

        try {
            $userModel = new UserModel(); // Instancia o seu model

            if ($isLiked) {
                // Chama o método para adicionar aos favoritos
                $userModel->addFavoriteCourse($userId, $courseId);
                $message = 'Curso adicionado aos favoritos.';
            } else {
                // Chama o método para remover dos favoritos
                $userModel->removeFavoriteCourse($userId, $courseId);
                $message = 'Curso removido dos favoritos.';
            }

            // Envia uma resposta de sucesso
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'message' => $message]);

        } catch (Exception $e) {
            // Em caso de erro no banco de dados
            http_response_code(500 ); // Internal Server Error
            echo json_encode(['success' => false, 'message' => 'Erro no servidor: ' . $e->getMessage()]);
        }
    }
}
