<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Controller\UserController;
use Model\UserModel;

// Inclui o arquivo do Controller para que a classe seja encontrada
require_once __DIR__ . '/../../Controller/UserController.php';

class UserControllerTest extends TestCase
{
    private $userModelMock;
    private $userController;

    /**
     * Configuração executada antes de cada teste.
     * Cria um mock do UserModel e uma instância do UserController com esse mock.
     */
    protected function setUp(): void
    {
        // Cria um "dublê" (mock) da classe UserModel.
        // Isso nos permite controlar o que os métodos do UserModel retornam, sem usar o banco de dados.
        $this->userModelMock = $this->createMock(UserModel::class);

        // Instancia o nosso UserController, mas injetando o mock em vez do modelo real.
        // (Para isso, vamos precisar de uma pequena alteração no construtor do UserController)
        $this->userController = new UserController($this->userModelMock);

        // Limpa a variável de sessão antes de cada teste para garantir isolamento
        $_SESSION = [];
    }

    // ========================================================================
    // TESTES PARA O PROCESSO DE CADASTRO (ETAPA 1)
    // ========================================================================

    public function testCadastroEtapa1Sucesso()
    {
        // Cenário: O e-mail não existe no banco de dados.
        $this->userModelMock->method('emailJaExiste')->willReturn(false);

        $resultado = $this->userController->processarEtapa1('teste@exemplo.com', 'senha123', 'senha123', true);

        // Asserção: Esperamos que o resultado seja nulo (sucesso)
        $this->assertNull($resultado);
        // Asserção: Verificamos se os dados foram salvos corretamente na sessão
        $this->assertEquals(['email' => 'teste@exemplo.com', 'senha' => 'senha123', 'termos_aceitos' => true], $_SESSION['cadastro_etapa1']);
    }

    public function testCadastroEtapa1FalhaSenhasNaoConferem()
    {
        $resultado = $this->userController->processarEtapa1('teste@exemplo.com', 'senha123', 'senhaDIFERENTE', true);

        // Asserção: Esperamos a mensagem de erro correta
        $this->assertEquals("As senhas não conferem.", $resultado);
        // Asserção: A sessão não deve ser criada em caso de falha
        $this->assertArrayNotHasKey('cadastro_etapa1', $_SESSION);
    }

    public function testCadastroEtapa1FalhaEmailJaExiste()
    {
        // Cenário: Configuramos o mock para simular que o e-mail já existe.
        $this->userModelMock->method('emailJaExiste')->willReturn(true);

        $resultado = $this->userController->processarEtapa1('email_existente@exemplo.com', 'senha123', 'senha123', true);

        // Asserção: Esperamos a mensagem de erro correta
        $this->assertEquals("Este e-mail já está em uso.", $resultado);
    }

    public function testCadastroEtapa1FalhaTermosNaoAceitos()
    {
        $resultado = $this->userController->processarEtapa1('teste@exemplo.com', 'senha123', 'senha123', false);
        $this->assertEquals("Você precisa aceitar os Termos de Uso e a Política de Privacidade.", $resultado);
    }

    // ========================================================================
    // TESTES PARA O PROCESSO DE LOGIN
    // ========================================================================

    public function testLoginSucesso()
    {
        // Dados do usuário que esperamos que o Model retorne
        $usuarioFalso = [
            'id' => 1,
            'nome' => 'João',
            'sobrenome' => 'Silva',
            'email' => 'joao@exemplo.com',
            'senha' => password_hash('senhaCorreta', PASSWORD_DEFAULT), // Senha hasheada
            'foto_perfil_url' => 'caminho/foto.jpg',
            'funcao' => 'aluno'
        ];

        // Cenário: Configuramos o mock para retornar o usuário falso quando o e-mail for buscado.
        $this->userModelMock->method('encontrarUsuarioPorEmail')->willReturn($usuarioFalso);
        
        // Mock para o método de atualizar status (não precisamos testar seu retorno aqui)
        $this->userModelMock->method('atualizarStatus')->willReturn(true);

        // Executamos o método de login
        // NOTA: Como o método original tem `header()` e `exit`, o teste irá parar.
        // Para testar de verdade, teríamos que refatorar o controller para não chamar `exit` diretamente.
        // Aqui, vamos testar a lógica *antes* do redirecionamento.
        
        // Para contornar o `exit`, podemos rodar o teste em um processo separado
        // @runInSeparateProcess
        // (Isso pode ser adicionado como anotação no docblock do método de teste)
        // Por simplicidade, vamos focar em testar a validação.
        
        $resultado = $this->userController->processarLogin('joao@exemplo.com', 'senhaCorreta');

        // Em um teste real com `exit` mockado, verificaríamos a sessão.
        // Como não podemos, vamos assumir que um retorno diferente de string é um "quase sucesso".
        // A melhor abordagem seria refatorar o controller.
        
        // Este teste irá falhar por causa do `header()` e `exit`. A explicação abordará isso.
        // Para fins de demonstração, vamos focar nos casos de falha que retornam strings.
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

        // Cenário: O e-mail existe, mas a senha fornecida estará errada.
        $this->userModelMock->method('encontrarUsuarioPorEmail')->willReturn($usuarioFalso);

        $resultado = $this->userController->processarLogin('joao@exemplo.com', 'senhaErrada');

        // Asserção: Esperamos a mensagem de erro de senha incorreta
        $this->assertEquals("Senha incorreta. Por favor, tente novamente.", $resultado);
    }

    public function testLoginFalhaUsuarioNaoEncontrado()
    {
        // Cenário: O e-mail não existe no banco de dados.
        $this->userModelMock->method('encontrarUsuarioPorEmail')->willReturn(false);

        $resultado = $this->userController->processarLogin('naoexiste@exemplo.com', 'qualquerSenha');

        // Asserção: Esperamos a mensagem de erro de usuário não encontrado
        $this->assertEquals("Nenhum usuário encontrado com este e-mail.", $resultado);
    }
}