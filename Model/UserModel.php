<?php
// Model/UserModel.php

class UserModel {
    public function getUserData() {
        return [
            'name' => 'Jeferson Souza',
            'role' => 'Aluno - Técnico em Logística',
            'days' => 80,
            'completed_courses' => 3,
            'ongoing_courses' => 2
        ];
    }

    public function getTrendingCourses() {
        return [
            // Links de imagem atualizados e válidos
            ['title' => 'ChatGPT no dia a dia: Automatize tarefas com texto', 'author' => 'Aline Santos', 'author_avatar' => 'https://i.imgur.com/JzJ3G3p.png', 'image' => 'https://i.imgur.com/8O4sEaR.png'],
            ['title' => 'Introdução à Inteligência Artificial para Leigos', 'author' => 'João Pedro', 'author_avatar' => 'https://i.imgur.com/uJSGg2x.png', 'image' => 'https://i.imgur.com/u1aA32J.png'],
            ['title' => 'Prompt Engineering para Iniciantes', 'author' => 'Pedro Carlos', 'author_avatar' => 'https://i.imgur.com/AOhh22f.png', 'image' => 'https://i.imgur.com/Y3eWf5p.png']
        ];
    }

    public function getOngoingCourses( ) {
        return [
            ['name' => 'IA para Pequenos Empreendedores', 'icon' => 'https://i.imgur.com/oPH5uV3.png'],
            ['name' => 'IA para Profissionais de RH', 'icon' => 'https://i.imgur.com/2j2eA2I.png'],
            ['name' => 'IA para Vendedores e Atendimento ao Cliente', 'icon' => 'https://i.imgur.com/xI1T3Yy.png'],
            ['name' => 'IA para Designers: Crie Artes e Protótipos com...', 'icon' => 'https://i.imgur.com/9sL5gC0.png']
        ];
    }
    
    public function getChatMessages( ) {
        return [
            ['sender' => 'Professor João', 'message' => 'Professor, eu gostaria de tirar...', 'time' => '22h00', 'avatar' => 'https://i.imgur.com/jNNT43D.png'],
            ['sender' => 'Professor Cleber', 'message' => 'Obrigado pelo retorno!', 'time' => '11h30', 'avatar' => 'https://i.imgur.com/AOhh22f.png'],
            ['sender' => 'José Felipe', 'message' => 'Rapaz, a situação é complica...', 'time' => '10h30', 'avatar' => 'https://i.imgur.com/JzJ3G3p.png'],
            ['sender' => 'Rafael Donelles', 'message' => 'Eu conversei com ele sobre...', 'time' => '9h00', 'avatar' => 'https://i.imgur.com/sVmu04Q.png'],
            ['sender' => 'Professor Yago', 'message' => 'A atividade está incompleta', 'time' => '8h00', 'avatar' => 'https://i.imgur.com/uJSGg2x.png']
        ];
    }
}
