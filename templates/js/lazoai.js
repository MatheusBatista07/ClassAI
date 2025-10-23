document.addEventListener('DOMContentLoaded', () => {
    const chatBody = document.getElementById('chat-body');
    const chatInput = document.getElementById('chat-input');
    const sendButton = document.getElementById('send-button');
    const welcomeMessage = document.querySelector('.welcome-message');

    sendButton.addEventListener('click', sendMessage);
    chatInput.addEventListener('keydown', (event) => {
        if (event.key === 'Enter') sendMessage();
    });

    async function sendMessage() {
        const userMessage = chatInput.value.trim();
        if (userMessage === '') return; // Não envia mensagens vazias

        if (welcomeMessage && welcomeMessage.style.display !== 'none') {
            welcomeMessage.style.display = 'none';
        }

        appendMessage(userMessage, 'user-message');
        chatInput.value = '';
        chatInput.disabled = true;
        sendButton.disabled = true;

        const typingIndicator = showTypingIndicator();

        try {
            // A URL que chama nosso roteador na raiz
            const response = await fetch('index.php?action=askLazo', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ question: userMessage }),
            });

            // Remove o indicador de "digitando"
            if (typingIndicator.parentNode) chatBody.removeChild(typingIndicator);

            // Pega o corpo da resposta para análise, mesmo se houver erro
            const responseBody = await response.text();

            if (!response.ok) {
                // Se a resposta NÃO for OK (erro 404, 500, etc.), lança um erro detalhado
                throw new Error(`Erro ${response.status}: ${response.statusText}. Resposta do servidor: ${responseBody}`);
            }
            
            // Tenta converter o corpo da resposta para JSON
            const data = JSON.parse(responseBody);
            appendMessage(data.reply, 'lazo-message');

        } catch (error) {
            if (typingIndicator.parentNode) chatBody.removeChild(typingIndicator);
            // Exibe a mensagem de erro detalhada no chat e no console
            const errorMessage = `Oops! Tive um problema. Detalhe: ${error.message}`;
            appendMessage(errorMessage, 'lazo-message');
            console.error("Erro detalhado no fetch:", error);
        } finally {
            // Reabilita os botões para que o usuário possa tentar de novo
            chatInput.disabled = false;
            sendButton.disabled = false;
            chatInput.focus();
        }
    }

    function appendMessage(text, className) {
        const messageElement = document.createElement('div');
        messageElement.classList.add('message', className);
        messageElement.innerText = text;
        chatBody.appendChild(messageElement);
        chatBody.scrollTop = chatBody.scrollHeight;
    }

    function showTypingIndicator() {
        const indicator = document.createElement('div');
        indicator.classList.add('message', 'lazo-message', 'typing-indicator');
        indicator.innerHTML = '<span></span><span></span><span></span>';
        chatBody.appendChild(indicator);
        chatBody.scrollTop = chatBody.scrollHeight;
        return indicator;
    }
});
