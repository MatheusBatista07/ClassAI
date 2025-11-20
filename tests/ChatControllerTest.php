<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Controller\ChatController;
use Model\ChatModel;
use Pusher\Pusher;

// Inclui os arquivos necessários para o teste
require_once __DIR__ . '/../../Controller/ChatController.php';
require_once __DIR__ . '/../../Model/ChatModel.php';

class ChatControllerTest extends TestCase
{
    private $chatModelMock;
    private $pusherMock;
    private ChatController $chatController;

    /**
     * Configuração executada antes de cada teste.
     */
    protected function setUp(): void
    {
        // 1. Cria os Mocks para as dependências
        $this->chatModelMock = $this->createMock(ChatModel::class);
        $this->pusherMock = $this->createMock(Pusher::class);

        // 2. Injeta os Mocks no construtor do ChatController
        $this->chatController = new ChatController($this->chatModelMock, $this->pusherMock);
    }

    // ========================================================================
    // TESTES PARA O MÉTODO getMessages
    // ========================================================================

    /**
     * @runInSeparateProcess
     * Esta anotação é necessária porque o método `getMessages` chama `header()` e `echo`.
     * Ela isola o teste em um processo separado para evitar erros de "headers already sent".
     */
    public function testGetMessagesRetornaJsonCorretamente()
    {
        // 1. Cenário (Arrange)
        $userId = 1;
        $contactId = 2;
        $mensagensFalsas = [
            ['id' => 1, 'id_remetente' => 1, 'conteudo' => 'Olá!', 'timestamp' => '2025-11-20 10:00:00'],
            ['id' => 2, 'id_remetente' => 2, 'conteudo' => 'Tudo bem?', 'timestamp' => '2025-11-20 10:01:00']
        ];

        // "Ensina" o mock do ChatModel a retornar as mensagens falsas quando `fetchMessages` for chamado
        $this->chatModelMock->method('fetchMessages')
            ->with($userId, $contactId) // Garante que o método foi chamado com os parâmetros corretos
            ->willReturn($mensagensFalsas);

        // 2. Ação (Act)
        // Inicia um "buffer de saída" para capturar o que seria impresso na tela pelo `echo`
        ob_start();
        $this->chatController->getMessages($userId, $contactId);
        $outputJson = ob_get_clean(); // Pega o conteúdo do buffer e o limpa

        // 3. Asserção (Assert)
        // Verifica se a saída capturada é um JSON válido e corresponde aos dados esperados
        $this->assertJson($outputJson);
        $this->assertEquals(json_encode($mensagensFalsas), $outputJson);
    }

    public function testGetMessagesComConversaVazia()
    {
        // 1. Cenário (Arrange)
        $userId = 1;
        $contactId = 3; // Um contato sem mensagens

        // O mock retornará um array vazio
        $this->chatModelMock->method('fetchMessages')->willReturn([]);

        // 2. Ação (Act)
        ob_start();
        $this->chatController->getMessages($userId, $contactId);
        $outputJson = ob_get_clean();

        // 3. Asserção (Assert)
        // Verifica se a saída é um JSON representando um array vazio
        $this->assertEquals('[]', $outputJson);
    }

    // NOTA SOBRE sendMessage:
    // Testar o método `sendMessage` unitariamente é complexo devido ao `file_get_contents('php://input')`
    // e às chamadas de `header()` e `echo`. Um teste de integração com um cliente HTTP simulado
    // seria mais apropriado. No entanto, podemos testar se os métodos corretos são chamados.

    public function testSendMessageChamaMetodosCorretosEmCasoDeSucesso()
    {
        // Este teste é mais avançado e verifica se os métodos foram chamados (Expectations)

        // 1. Cenário (Arrange)
        // Esperamos que `saveMessage` seja chamado UMA VEZ e retorne `true`
        $this->chatModelMock->expects($this->once())
            ->method('saveMessage')
            ->willReturn(true);

        // Esperamos que `trigger` do Pusher seja chamado UMA VEZ
        $this->pusherMock->expects($this->once())
            ->method('trigger');

        // Ação e Asserção são combinadas aqui. O PHPUnit verificará se as expectativas
        // foram atendidas ao final do teste. Para simular o `php://input`, teríamos que
        // usar um stream wrapper, o que complica o teste.
        // Por isso, este método serve mais como um exemplo conceitual.
        
        $this->markTestIncomplete(
            'Testar sendMessage requer simulação de `php://input`, o que está além do escopo de um teste unitário simples.'
        );
    }
}
