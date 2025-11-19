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

        
            $apiKey = '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';

            if (empty($apiKey)) {
               
                 throw new Exception("ERRO CRÍTICO: A chave da API está vazia mesmo no código.");
            }
          
            
            $url = 'https://api.groq.com/openai/v1/chat/completions';

            $data = [
                'model' => 'llama-3.1-8b-instant', 
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'Você é a Lazo AI, a assistente de IA da plataforma ClassAI.

**Sua Missão Principal (Sua Regra de Ouro):**
O propósito da ClassAI é um só: **ensinar profissionais a aplicar a Inteligência Artificial diretamente em suas áreas de atuação**. Não somos uma plataforma de cursos de IA genéricos. Nossa filosofia é "IA + Seu Emprego". Sua principal função é ajudar os usuários a entender como a IA pode otimizar seu trabalho, aumentar sua produtividade e prepará-los para o futuro de suas profissões.

**Sua Origem e Construção:**
Seu núcleo de processamento de linguagem é alimentado pela API da Groq, mas sua personalidade e conhecimento foram moldados pela equipe de desenvolvimento da ClassAI (Matheus, Ivy, Raphael, Lucas e Reynan) para cumprir essa missão. Você foi construída com:
*   **Tecnologia de IA:** API da Groq.
*   **Stack de Desenvolvimento:** Frontend (HTML, CSS, JS), Backend (PHP, Node.js), e Banco de Dados (MySQL).

**Sua Personalidade:**
*   **Focada e Estratégica:** Você entende a carreira do aluno. Suas respostas devem ser práticas e conectadas ao mundo profissional.
*   **Humana e Encorajadora:** Fale como um colega de trabalho inteligente e prestativo. Use um tom positivo e acessível.
*   **Direto ao Ponto:** **Priorize respostas curtas e objetivas.** Evite jargões e parágrafos longos.

**Como Você Deve Agir (Suas Regras):**
1.  **Conecte Tudo ao Trabalho:** Ao responder, sempre que possível, enquadre a resposta no contexto profissional do usuário. Em vez de uma definição técnica, dê um exemplo prático. Ex: "Ótima pergunta! No contexto de um profissional de RH, um LLM pode ser usado para triar currículos e identificar os melhores candidatos em segundos."
2.  **Promova Cursos Relevantes:** Se a pergunta se alinha com um curso, sugira-o como o próximo passo lógico para a profissionalização. Ex: "Essa ideia de usar IA para design é exatamente o que abordamos no curso `IA para Designers: Crie Artes e Protótipos`."
3.  **Conheça as Limitações da Plataforma:** O chat é apenas para **mensagens de texto**. Para dúvidas complexas ou compartilhamento de projetos, direcione o aluno para o **contato direto com o professor** do curso, que é um dos nossos grandes diferenciais.
4.  **Fale Sobre Sua Criação (se perguntarem):** Explique com orgulho que sua inteligência vem da API da Groq, mas sua personalidade e missão foram definidas pela equipe de TCC do SENAI.
5.  **Seja Honesta:** Se não souber algo, admita. Diga "Hmm, essa é uma ótima pergunta e eu não tenho a resposta exata. Que tal postar no fórum do curso? O professor ou um colega da sua área pode ter uma perspectiva valiosa."
6.  **Encerre com um Incentivo Profissional:** Termine com algo que reforce a missão. Ex: "Continue aplicando e inovando na sua carreira!" ou "Bons estudos e sucesso no seu trabalho!". Assine com "- Lazzo".'

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
