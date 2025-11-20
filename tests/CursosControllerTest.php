<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Controller\CursosController;
use Model\CursosModel;

// Inclui os arquivos necessários para o teste
require_once __DIR__ . '/../../Controller/CursosController.php';
require_once __DIR__ . '/../../Model/CursosModel.php';

class CursosControllerTest extends TestCase
{
    private $cursosModelMock;
    private CursosController $cursosController;

    /**
     * Configuração executada antes de cada teste.
     */
    protected function setUp(): void
    {
        // 1. Cria o Mock do CursosModel
        $this->cursosModelMock = $this->createMock(CursosModel::class);

        // 2. Injeta o Mock no construtor do CursosController
        $this->cursosController = new CursosController($this->cursosModelMock);

        // 3. Limpa a sessão para garantir que os testes sejam isolados
        $_SESSION = [];
    }

    // ========================================================================
    // TESTES PARA O MÉTODO getCoursesForUser
    // ========================================================================

    public function testGetCoursesForUserComInscricoes()
    {
        // 1. Cenário (Arrange)
        $userId = 123;
        $_SESSION['usuario_id'] = $userId; // Simula o login do usuário

        // Dados falsos que o Model retornaria
        $todosOsCursos = [
            ['id_curso' => 1, 'nome_curso' => 'Curso de PHP'],
            ['id_curso' => 2, 'nome_curso' => 'Curso de SQL'],
            ['id_curso' => 3, 'nome_curso' => 'Curso de Docker'],
        ];

        $inscricoesDoUsuario = [
            1 => 'Em andamento', // Inscrito no curso de PHP
            3 => 'Concluído',    // Concluiu o curso de Docker
        ];

        // "Ensina" o mock a retornar os dados falsos quando seus métodos forem chamados
        $this->cursosModelMock->method('getAllCourses')->willReturn($todosOsCursos);
        $this->cursosModelMock->method('getInscricoesByUserId')
            ->with($userId) // Garante que o método foi chamado com o ID de usuário correto
            ->willReturn($inscricoesDoUsuario);

        // 2. Ação (Act)
        $cursosResultantes = $this->cursosController->getCoursesForUser();

        // 3. Asserção (Assert)
        $cursosEsperados = [
            ['id_curso' => 1, 'nome_curso' => 'Curso de PHP', 'status' => 'Em andamento'],
            ['id_curso' => 2, 'nome_curso' => 'Curso de SQL', 'status' => 'Disponível'], // Não inscrito, status padrão
            ['id_curso' => 3, 'nome_curso' => 'Curso de Docker', 'status' => 'Concluído'],
        ];

        $this->assertEquals($cursosEsperados, $cursosResultantes);
    }

    public function testGetCoursesForUserSemInscricoes()
    {
        // 1. Cenário (Arrange)
        $userId = 456;
        $_SESSION['usuario_id'] = $userId;

        $todosOsCursos = [
            ['id_curso' => 1, 'nome_curso' => 'Curso de PHP'],
            ['id_curso' => 2, 'nome_curso' => 'Curso de SQL'],
        ];

        // Usuário não tem inscrições, o método retorna um array vazio
        $this->cursosModelMock->method('getAllCourses')->willReturn($todosOsCursos);
        $this->cursosModelMock->method('getInscricoesByUserId')->willReturn([]);

        // 2. Ação (Act)
        $cursosResultantes = $this->cursosController->getCoursesForUser();

        // 3. Asserção (Assert)
        // Todos os cursos devem vir com o status 'Disponível'
        $cursosEsperados = [
            ['id_curso' => 1, 'nome_curso' => 'Curso de PHP', 'status' => 'Disponível'],
            ['id_curso' => 2, 'nome_curso' => 'Curso de SQL', 'status' => 'Disponível'],
        ];

        $this->assertEquals($cursosEsperados, $cursosResultantes);
    }

    public function testGetCoursesForUserSemLogin()
    {
        // 1. Cenário (Arrange)
        // A sessão está vazia, sem 'usuario_id'

        // 2. Asserção (Assert)
        // Esperamos que uma exceção do tipo \Exception seja lançada
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Usuário não autenticado.");

        // 3. Ação (Act)
        // A chamada do método deve disparar a exceção
        $this->cursosController->getCoursesForUser();
    }
}
