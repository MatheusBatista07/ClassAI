<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Controller\CursosController;
use Model\CursosModel;

class CursosControllerTest extends TestCase
{
    private $cursosModelMock;
    private CursosController $cursosController;

    protected function setUp(): void
    {
        $this->cursosModelMock = $this->createMock(CursosModel::class);
        $this->cursosController = new CursosController($this->cursosModelMock);
        $_SESSION = [];
    }

    public function testGetCoursesForUserComInscricoes()
    {
        // Inicia a sessão de forma segura
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $userId = 123;
        $_SESSION['usuario_id'] = $userId;

        $todosOsCursos = [ // <-- Definida com 'o'
            ['id_curso' => 1, 'nome_curso' => 'Curso de PHP'],
            ['id_curso' => 2, 'nome_curso' => 'Curso de SQL'],
            ['id_curso' => 3, 'nome_curso' => 'Curso de Docker'],
        ];
        $inscricoesDoUsuario = [1 => 'Em andamento', 3 => 'Concluído'];

        // CORREÇÃO APLICADA AQUI:
        $this->cursosModelMock->method('getAllCourses')->willReturn($todosOsCursos); // <-- Corrigido para 'o'
        $this->cursosModelMock->method('getInscricoesByUserId')->with($userId)->willReturn($inscricoesDoUsuario);

        $cursosResultantes = $this->cursosController->getCoursesForUser();

        $cursosEsperados = [
            ['id_curso' => 1, 'nome_curso' => 'Curso de PHP', 'status' => 'Em andamento'],
            ['id_curso' => 2, 'nome_curso' => 'Curso de SQL', 'status' => 'Disponível'],
            ['id_curso' => 3, 'nome_curso' => 'Curso de Docker', 'status' => 'Concluído'],
        ];

        $this->assertEquals($cursosEsperados, $cursosResultantes);
    }

    public function testGetCoursesForUserSemInscricoes()
    {
        // CORREÇÃO: Inicia a sessão de forma segura
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $userId = 456;
        $_SESSION['usuario_id'] = $userId;

        $todosOsCursos = [
            ['id_curso' => 1, 'nome_curso' => 'Curso de PHP'],
            ['id_curso' => 2, 'nome_curso' => 'Curso de SQL'],
        ];

        $this->cursosModelMock->method('getAllCourses')->willReturn($todosOsCursos);
        $this->cursosModelMock->method('getInscricoesByUserId')->willReturn([]);

        $cursosResultantes = $this->cursosController->getCoursesForUser();

        $cursosEsperados = [
            ['id_curso' => 1, 'nome_curso' => 'Curso de PHP', 'status' => 'Disponível'],
            ['id_curso' => 2, 'nome_curso' => 'Curso de SQL', 'status' => 'Disponível'],
        ];

        $this->assertEquals($cursosEsperados, $cursosResultantes);
    }

    public function testGetCoursesForUserSemLogin()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("Usuário não autenticado.");
        $this->cursosController->getCoursesForUser();
    }
}
