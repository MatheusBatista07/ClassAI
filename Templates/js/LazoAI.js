document.addEventListener('DOMContentLoaded', () => {
    console.log("LazoAI.js: Script carregado.");

    const chatBody = document.getElementById('chat-body');
    const chatInput = document.getElementById('chat-input');
    const sendButton = document.getElementById('send-button');
    const welcomeMessage = document.querySelector('.lazo-welcome-message');

    if (!chatBody || !chatInput || !sendButton) {
        console.error("LazoAI.js: Elementos essenciais do chat não foram encontrados. O script não pode continuar.");
        return;
    }
    console.log("LazoAI.js: Elementos do chat encontrados com sucesso.");

   
    function appendMessage(text, className) {
        console.log(`LazoAI.js: Adicionando mensagem "${text}" com a classe ${className}`);
        const messageElement = document.createElement('div');
        
        messageElement.classList.add('lazo-message', className);

        if (className === 'lazo-ai-message') {
            messageElement.innerHTML = marked.parse(text);
        } else {
            messageElement.innerText = text;
        }

        chatBody.appendChild(messageElement);
        chatBody.scrollTop = chatBody.scrollHeight; 
    }

  
    function showTypingIndicator() {
        const indicator = document.createElement('div');
        indicator.classList.add('lazo-message', 'lazo-ai-message', 'lazo-typing-indicator');
        indicator.innerHTML = '<span></span><span></span><span></span>';
        chatBody.appendChild(indicator);
        chatBody.scrollTop = chatBody.scrollHeight;
        return indicator;
    }

 
    async function sendMessage() {
        console.log("LazoAI.js: Função sendMessage() foi chamada.");
        const userMessage = chatInput.value.trim();
        if (userMessage === '') {
            console.warn("LazoAI.js: Tentativa de enviar mensagem vazia.");
            return;
        }

        if (welcomeMessage && welcomeMessage.style.display !== 'none') {
            welcomeMessage.style.display = 'none';
        }

        appendMessage(userMessage, 'lazo-user-message');
        chatInput.value = '';
        chatInput.disabled = true;
        sendButton.disabled = true;

        const typingIndicator = showTypingIndicator();

        try {
            console.log(`LazoAI.js: Enviando requisição para a API com a pergunta: "${userMessage}"`);
            
            const response = await fetch('/ClassAI/api.php?action=askLazo', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ question: userMessage }),
            });
            console.log("LazoAI.js: Resposta da API recebida.", response);

            if (typingIndicator.parentNode) {
                chatBody.removeChild(typingIndicator);
            }

            if (!response.ok) {
                throw new Error(`Erro de rede ou servidor: ${response.status} ${response.statusText}`);
            }
            
            const data = await response.json();
            console.log("LazoAI.js: Dados da resposta (JSON):", data);
           
            if (data.error) {
                appendMessage(data.error, 'lazo-ai-message');
            } else {
                appendMessage(data.reply, 'lazo-ai-message');
            }

        } catch (error) {
            console.error("LazoAI.js: Erro CRÍTICO no bloco try/catch:", error);
            if (typingIndicator.parentNode) {
                chatBody.removeChild(typingIndicator);
            }
            appendMessage('Oops! Não consegui me conectar. Verifique o console (F12) para mais detalhes.', 'lazo-ai-message');
        } finally {
            chatInput.disabled = false;
            sendButton.disabled = false;
            chatInput.focus();
        }
    }

  
    sendButton.addEventListener('click', sendMessage);
    chatInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') {
            event.preventDefault();
            sendMessage();
        }
    });

    console.log("LazoAI.js: Escutadores de evento adicionados.");
});
