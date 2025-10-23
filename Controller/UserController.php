<?php

class UserController {

    public function askLazo() {
        header('Content-Type: application/json');
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            $userQuestion = $input['question'] ?? null;

            if (!$userQuestion) {
                http_response_code(400 );
                echo json_encode(['error' => 'Nenhuma pergunta foi fornecida.']);
                return;
            }

            $apiKey = $_ENV['GOOGLE_API_KEY'] ?? null;
            if (!$apiKey) {
                 throw new Exception("Chave da API do Google não encontrada. Verifique seu arquivo .env.");
            }
            
            // ==================================================================
            // CORREÇÃO FINAL: Usando o endpoint MAIS ESTÁVEL e o modelo MAIS COMPATÍVEL
            // ==================================================================
            $model = 'gemini-1.0-pro'; // O modelo mais compatível
            $url = 'https://generativelanguage.googleapis.com/v1beta/models/' . $model . ':generateContent?key=' . $apiKey;

            $data = [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => 'Você é a Lazo AI, uma assistente de IA amigável e prestativa da plataforma de e-learning ClassAI. Seu propósito é ajudar os alunos. Suas respostas devem ser concisas e encorajadoras. Responda à seguinte pergunta: ' . $userQuestion]
                        ]
                    ]
                ]
            ];

            $ch = curl_init($url );
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE );
            curl_close($ch);

            if ($httpcode !== 200 ) {
                throw new Exception("Erro na API do Google (Código: $httpcode ). Resposta: " . $response);
            }

            $result = json_decode($response, true);
            
            if (empty($result['candidates'][0]['content']['parts'][0]['text'])) {
                 // Verifica se o bloqueio foi por segurança
                 if (!empty($result['promptFeedback']['blockReason'])) {
                    throw new Exception("A API do Google bloqueou a resposta por segurança. Motivo: " . $result['promptFeedback']['blockReason']);
                 }
                 throw new Exception("A API do Google retornou uma resposta vazia ou em um formato inesperado.");
            }

            $lazoResponse = $result['candidates'][0]['content']['parts'][0]['text'];

            echo json_encode(['reply' => $lazoResponse]);

        } catch (Exception $e) {
            http_response_code(500 );
            echo json_encode(['error' => 'Erro ao contatar a Lazo AI: ' . $e->getMessage()]);
        }
    }
}
