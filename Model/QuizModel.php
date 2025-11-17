<?php

namespace Model;

use PDO;

require_once __DIR__ . '/../Model/Connection.php';

class QuizModel
{
    private $db;

    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    /**
     * Busca todas as questões e suas respectivas opções de resposta para uma aula específica.
     *
     * @param int $aulaId O ID da aula.
     * @return array Um array de questões, onde cada questão contém suas opções.
     */
    public function getQuestoesByAulaId(int $aulaId): array
    {
        // SQL para buscar as questões da aula
        $sqlQuestoes = "SELECT id_questao, enunciado_questao, ordem 
                        FROM questoes 
                        WHERE id_aula_fk = ? 
                        ORDER BY ordem ASC";

        $stmtQuestoes = $this->db->prepare($sqlQuestoes);
        $stmtQuestoes->execute([$aulaId]);
        $questoes = $stmtQuestoes->fetchAll(PDO::FETCH_ASSOC);

        if (empty($questoes)) {
            return [];
        }

        // Prepara o SQL para buscar as opções de todas as questões de uma vez
        $idsQuestoes = array_column($questoes, 'id_questao');
        $placeholders = implode(',', array_fill(0, count($idsQuestoes), '?'));

        $sqlOpcoes = "SELECT id_opcao, id_questao_fk, texto_opcao, correta 
                      FROM opcoes_resposta 
                      WHERE id_questao_fk IN ($placeholders)";

        $stmtOpcoes = $this->db->prepare($sqlOpcoes);
        $stmtOpcoes->execute($idsQuestoes);
        $opcoes = $stmtOpcoes->fetchAll(PDO::FETCH_ASSOC);

        // Agrupa as opções por questão
        $opcoesPorQuestao = [];
        foreach ($opcoes as $opcao) {
            $opcoesPorQuestao[$opcao['id_questao_fk']][] = $opcao;
        }

        // Anexa as opções a cada questão correspondente
        foreach ($questoes as $key => $questao) {
            $questoes[$key]['opcoes'] = $opcoesPorQuestao[$questao['id_questao']] ?? [];
        }

        return $questoes;
    }
}
