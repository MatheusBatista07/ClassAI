<?php
// Arquivo: Controller/LazoController.php (VERSÃO FINAL PADRONIZADA)

// ADICIONADO: Declara o namespace para ser consistente com o resto do projeto.
namespace Controller;

// A classe Exception já está no namespace global, não precisa de 'use'.

class LazoController {

    public function askLazo() {
        // Não precisa carregar nada aqui. O api.php já carregou o Configuration.php.

        header('Content-Type: application/json');
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            $userQuestion = $input['question'] ?? null;

            if (!$userQuestion) {
                http_response_code(400 );
                echo json_encode(['error' => 'Nenhuma pergunta foi fornecida.']);
                return;
            }

            // Usa a constante global GROQ_API_KEY definida no Configuration.php
            if (!defined('GROQ_API_KEY') || empty(GROQ_API_KEY)) {
                 throw new \Exception("Constante GROQ_API_KEY não foi definida ou está vazia no arquivo Configuration.php.");
            }
            $apiKey = GROQ_API_KEY;
            
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
            
            if (curl_errno($ch)) {
                $curlError = curl_error($ch);
                curl_close($ch);
                throw new \Exception("Erro na chamada cURL: " . $curlError);
            }
            
            curl_close($ch);

            if ($httpcode !== 200 ) {
                throw new \Exception("Erro na API da Groq (Código: $httpcode ). Resposta do servidor: " . $response);
            }

            $result = json_decode($response, true);
            $lazoResponse = $result['choices'][0]['message']['content'] ?? "Desculpe, não consegui processar sua pergunta no momento.";
            
            echo json_encode(['reply' => $lazoResponse]);

        } catch (\Exception $e) {
            http_response_code(500 );
            echo json_encode(['error' => 'Erro interno ao contatar a Lazo AI: ' . $e->getMessage()]);
        }
    }
}
