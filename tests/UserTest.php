<?php

use PHPUnit\Framework\TestCase;
use Controller\UserController;
use Model\UserModel;

class UserTest extends TestCase
{
    private $userController;
    private $mockUserModel;

    public function setUp(): void
    {
        $this->mockUserModel = $this->createMock(UserModel::class);
        $this->userController = new UserController($this->mockUserModel);
    }

     #[\PHPUnit\Framework\Attributes\Test]
     public function it_shouldnt_be_able_to_go_to_second_page_with_empty_inputs(){
        $resultado = $this->userController->processarEtapa1('', 'senha123', 'senha123', true);
        $this->assertEquals("E-mail e senha são obrigatórios.", $resultado);

        $resultado = $this->userController->processarEtapa1('nome@example.com', '', 'senha123', true);
        $this->assertEquals("E-mail e senha são obrigatórios.", $resultado);

     }

     #[\PHPUnit\Framework\Attributes\Test]
     public function it_shouldnt_be_able_to_go_to_second_page_with_uncheck_terms(){
        $resultado = $this->userController->processarEtapa1('teste@email.com', 'senha123', 'senhaDiferente', true);
        $this->assertEquals("As senhas não conferem.", $resultado);
     }

}


?>