<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Controller\ChatController;
use Model\ChatModel;
use Pusher\Pusher;

class ChatControllerTest extends TestCase
{
    private $chatModelMock;
    private $pusherMock;
    private ChatController $chatController;

    protected function setUp(): void
    {
        $this->chatModelMock = $this->createMock(ChatModel::class);
        $this->pusherMock = $this->createMock(Pusher::class);
        $this->chatController = new ChatController($this->chatModelMock, $this->pusherMock);
        
        // CORREÇÃO: Inicia a sessão de forma segura
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION = [];
    }

    public function testGetMessagesRetornaJsonCorretamente()
    {
        $userId = 1;
        $contactId = 2;
        $_SESSION['usuario_id'] = $userId;

        $mensagensFalsas = [
            ['id' => 1, 'conteudo' => 'Olá Mundo', 'id_remetente' => $userId],
            ['id' => 2, 'conteudo' => 'Outra mensagem', 'id_remetente' => $contactId]
        ];

        $this->chatModelMock->method('fetchMessages')
            ->with($userId, $contactId)
            ->willReturn($mensagensFalsas);

        ob_start();
        $this->chatController->getMessages($userId, $contactId); 
        $saidaJson = ob_get_clean();

        $this->assertJsonStringEqualsJsonString(json_encode($mensagensFalsas), $saidaJson);
    }

    public function testGetMessagesComConversaVazia()
    {
        $userId = 1;
        $contactId = 3;
        $_SESSION['usuario_id'] = $userId;

        $this->chatModelMock->method('fetchMessages')
            ->with($userId, $contactId)
            ->willReturn([]);

        ob_start();
        $this->chatController->getMessages($userId, $contactId);
        $saidaJson = ob_get_clean();

        $this->assertJsonStringEqualsJsonString('[]', $saidaJson);
    }

    public function testSendMessageChamaMetodosCorretosEmCasoDeSucesso()
    {
        $this->markTestIncomplete(
            'Este teste precisa ser refatorado para o modelo de chat usuário-a-usuário.'
        );
    }
}
