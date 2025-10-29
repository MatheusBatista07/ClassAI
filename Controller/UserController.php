<?php
// Controller/UserController.php (CORRIGIDO)

class UserController {
    public function index() {
        // Inclui o Model usando o caminho absoluto a partir da raiz do projeto
        // A constante ROOT_PATH é definida no index.php
        require_once ROOT_PATH . 'Model/UserModel.php';
        
        $userModel = new UserModel();
        
        $userData = $userModel->getUserData();
        $trendingCourses = $userModel->getTrendingCourses();
        $ongoingCourses = $userModel->getOngoingCourses();
        $chatMessages = $userModel->getChatMessages();

        // **A CORREÇÃO DEFINITIVA ESTÁ AQUI**
        // O caminho correto é 'View/PaginaHome.php', sem a subpasta 'pagina'.
        require ROOT_PATH . 'View/PaginaHome.php';
    }
}
