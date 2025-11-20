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

            $apiKey = $_ENV['GROQ_API_KEY'] ?? null;
            if (!$apiKey) {
                 throw new Exception("Chave da API da Groq não encontrada. Verifique seu arquivo .env.");
            }
            
            $url = 'https://api.groq.com/openai/v1/chat/completions';

          
            $data = [
                'model' => 'llama-3.1-8b-instant', 
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Você é a Lazo AI, uma assistente de IA amigável e prestativa da plataforma de e-learning ClassAI. Seu propósito é ajudar os alunos, respondendo duvidas e auxiliando para melhor aprendizado. Suas respostas devem ser concisas e encorajadoras.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $userQuestion
                    ]
                ]
            ];

            $headers = [
                'Authorization: Bearer ' . $apiKey,
                'Content-Type: application/json'
            ];

            $ch = curl_init($url );
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE );
            curl_close($ch);

            if ($httpcode !== 200 ) {
                throw new Exception("Erro na API da Groq (Código: $httpcode ). Resposta: " . $response);
            }

            $result = json_decode($response, true);

            $lazoResponse = $result['choices'][0]['message']['content'] ?? "Desculpe, não consegui processar sua pergunta no momento.";

            echo json_encode(['reply' => $lazoResponse]);

        } catch (Exception $e) {
            http_response_code(500 );
            echo json_encode(['error' => 'Erro ao contatar a Lazo AI: ' . $e->getMessage()]);
        }
    }
}
