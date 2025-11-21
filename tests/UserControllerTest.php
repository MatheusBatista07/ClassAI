<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Controller\UserController;
use Model\UserModel;

class UserControllerTest extends TestCase
{
    private $userModelMock;
    private $userController;

    protected function setUp(): void
    {
        $this->userModelMock = $this->createMock(UserModel::class);
        $this->userController = new UserController($this->userModelMock);
        $_SESSION = [];
    }

    public function testCadastroEtapa1Sucesso()
    {
        $this->userModelMock->method('emailJaExiste')->willReturn(false);
        $resultado = $this->userController->processarEtapa1('teste@exemplo.com', 'senha123', 'senha123', true);
        $this->assertNull($resultado);
        $this->assertEquals(['email' => 'teste@exemplo.com', 'senha' => 'senha123', 'termos_aceitos' => true], $_SESSION['cadastro_etapa1']);
    }

    public function testCadastroEtapa1FalhaSenhasNaoConferem()
    {
        $resultado = $this->userController->processarEtapa1('teste@exemplo.com', 'senha123', 'senhaDIFERENTE', true);
        $this->assertEquals("As senhas não conferem.", $resultado);
        $this->assertArrayNotHasKey('cadastro_etapa1', $_SESSION);
    }

    public function testCadastroEtapa1FalhaEmailJaExiste()
    {
        $this->userModelMock->method('emailJaExiste')->willReturn(true);
        $resultado = $this->userController->processarEtapa1('email_existente@exemplo.com', 'senha123', 'senha123', true);
        $this->assertEquals("Este e-mail já está em uso.", $resultado);
    }

    public function testCadastroEtapa1FalhaTermosNaoAceitos()
    {
        $resultado = $this->userController->processarEtapa1('teste@exemplo.com', 'senha123', 'senha123', false);
        $this->assertEquals("Você precisa aceitar os Termos de Uso e a Política de Privacidade.", $resultado);
    }

    public function testLoginSucesso()
    {
        $this->markTestIncomplete(
            'Este teste não pode ser concluído sem refatorar o UserController para remover header() e exit() do método de login.'
        );
    }

    public function testLoginFalhaSenhaIncorreta()
    {
        $usuarioFalso = [
            'id' => 1,
            'email' => 'joao@exemplo.com',
            'senha' => password_hash('senhaCorreta', PASSWORD_DEFAULT)
        ];
        $this->userModelMock->method('encontrarUsuarioPorEmail')->willReturn($usuarioFalso);
        $resultado = $this->userController->processarLogin('joao@exemplo.com', 'senhaErrada');
        $this->assertEquals("Senha incorreta. Por favor, tente novamente.", $resultado);
    }

    public function testLoginFalhaUsuarioNaoEncontrado()
    {
        $this->userModelMock->method('encontrarUsuarioPorEmail')->willReturn(false);
        $resultado = $this->userController->processarLogin('naoexiste@exemplo.com', 'qualquerSenha');
        $this->assertEquals("Nenhum usuário encontrado com este e-mail.", $resultado);
    }
}
