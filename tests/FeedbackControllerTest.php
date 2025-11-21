<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
// A linha 'use PHPUnit\Framework\MockObject\MockObject;' foi omitida conforme solicitado.
use Controller\FeedbackController;
use Model\Feedback;
use Model\CursosModel;

// Inclui os arquivos necessários para o teste
require_once __DIR__ . '/../../Controller/FeedbackController.php';
require_once __DIR__ . '/../../Model/Feedback.php';
require_once __DIR__ . '/../../Model/CursosModel.php';

class FeedbackControllerTest extends TestCase
{
    // Declaração das propriedades com interseção de tipos
    private $feedbackModelMock;
    private $cursosModelMock;
    private FeedbackController $feedbackController;

    /**
     * Configuração executada antes de cada teste.
     */
    protected function setUp(): void
    {
        // Cria os Mocks para as dependências
        $this->feedbackModelMock = $this->createMock(Feedback::class);
        $this->cursosModelMock = $this->createMock(CursosModel::class);

        // Injeta os Mocks no construtor do FeedbackController
        $this->feedbackController = new FeedbackController(
            $this->feedbackModelMock,
            $this->cursosModelMock
        );
    }

    // ========================================================================
    // TESTES PARA O MÉTODO submitMessage
    // ========================================================================

    public function testSubmitMessageSucesso()
    {
        // 1. Cenário (Arrange)
        // "Ensina" o mock a retornar 'true' quando 'saveFeedBack' for chamado
        $this->feedbackModelMock->method('saveFeedBack')->willReturn(true);

        // 2. Ação (Act)
        $resultado = $this->feedbackController->submitMessage('Ótimo curso!', 'João Silva', 'joao@exemplo.com');

        // 3. Asserção (Assert)
        $this->assertTrue($resultado);
    }

    public function testSubmitMessageFalhaCamposVazios()
    {
        // Testa com a mensagem vazia
        $resultado = $this->feedbackController->submitMessage('', 'João Silva', 'joao@exemplo.com');
        $this->assertFalse($resultado);

        // Testa com o nome vazio
        $resultado = $this->feedbackController->submitMessage('Ótimo curso!', '', 'joao@exemplo.com');
        $this->assertFalse($resultado);
    }

    public function testSubmitMessageFalhaEmailInvalido()
    {
        $resultado = $this->feedbackController->submitMessage('Ótimo curso!', 'João Silva', 'email-invalido');
        $this->assertFalse($resultado);
    }

    // ========================================================================
    // TESTES PARA O MÉTODO handleCancelamento
    // ========================================================================

    public function testHandleCancelamentoComMotivo()
    {
        // 1. Cenário (Arrange)
        // Esperamos que o método de salvar feedback seja chamado UMA VEZ
        $this->feedbackModelMock->expects($this->once())
            ->method('salvarFeedbackCancelamento')
            ->with(1, 10, 'O curso não atendeu às expectativas.');

        // Esperamos que o método de cancelar matrícula retorne 'true'
        $this->cursosModelMock->method('cancelarMatricula')->willReturn(true);

        // 2. Ação (Act)
        $resultado = $this->feedbackController->handleCancelamento(1, 10, 'O curso não atendeu às expectativas.');

        // 3. Asserção (Assert)
        $this->assertTrue($resultado);
    }

    public function testHandleCancelamentoSemMotivo()
    {
        // 1. Cenário (Arrange)
        // Esperamos que o método de salvar feedback NUNCA seja chamado
        $this->feedbackModelMock->expects($this->never())
            ->method('salvarFeedbackCancelamento');

        // O método de cancelar matrícula ainda deve ser chamado e retornar 'true'
        $this->cursosModelMock->method('cancelarMatricula')->willReturn(true);

        // 2. Ação (Act)
        $resultado = $this->feedbackController->handleCancelamento(1, 10, ''); // Motivo vazio

        // 3. Asserção (Assert)
        $this->assertTrue($resultado);
    }

    public function testHandleCancelamentoFalhaAoCancelarMatricula()
    {
        // 1. Cenário (Arrange)
        // O método de salvar feedback pode ou não ser chamado, não é o foco aqui.
        
        // Simulamos uma falha no cancelamento da matrícula
        $this->cursosModelMock->method('cancelarMatricula')->willReturn(false);

        // 2. Ação (Act)
        $resultado = $this->feedbackController->handleCancelamento(1, 10, 'Qualquer motivo');

        // 3. Asserção (Assert)
        // O resultado final do controller deve ser 'false'
        $this->assertFalse($resultado);
    }
}