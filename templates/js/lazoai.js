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
        if (userMessage === '') return;

        if (welcomeMessage && welcomeMessage.style.display !== 'none') {
            welcomeMessage.style.display = 'none';
        }

        // Usa a função appendMessage correta
        appendMessage(userMessage, 'user-message');
        chatInput.value = '';
        chatInput.disabled = true;
        sendButton.disabled = true;

        const typingIndicator = showTypingIndicator();

        try {
            const response = await fetch('index.php?action=askLazo', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ question: userMessage }),
            });

            if (typingIndicator.parentNode) chatBody.removeChild(typingIndicator);
            
            const responseBody = await response.text();

            if (!response.ok) {
                throw new Error(`Erro ${response.status}: ${response.statusText}. Resposta do servidor: ${responseBody}`);
            }
            
            const data = JSON.parse(responseBody);
           
            appendMessage(data.reply, 'lazo-message');

        } catch (error) {
            if (typingIndicator.parentNode) chatBody.removeChild(typingIndicator);
            const errorMessage = `Oops! Tive um problema. Detalhe: ${error.message}`;
            appendMessage(errorMessage, 'lazo-message');
            console.error("Erro detalhado no fetch:", error);
        } finally {
            chatInput.disabled = false;
            sendButton.disabled = false;
            chatInput.focus();
        }
    }

    function appendMessage(text, className) {
        const messageElement = document.createElement('div');
        messageElement.classList.add('message', className);

        if (className === 'lazo-message') {
    
            messageElement.innerHTML = marked.parse(text); 
        } else {
           
            messageElement.innerText = text;
        }

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
