<div id="lazo-popup-overlay" class="lazo-popup-overlay">
    <div class="chat-container" id="chatbot-container">
        <header class="chat-header">
            <div class="header-content">
                <a href="#" id="lazo-close-button" class="close-button">&times;</a>
                <h1>Lazo AI</h1>
            </div>
            <img src="..\Images\Pagina-de-Apresentacao\Lazo.png" alt="Mascote Lazo AI" class="mascot">
        </header>
        <main id="chat-body" class="chat-body">
            <div class="welcome-message">
                <h2>Faça uma pergunta à Lazo</h2>
                <p>A IA irá te ajudar no processo de aprendizagem</p>
            </div>
        </main>
        <footer class="chat-footer">
            <div class="input-wrapper">
                <input type="text" id="chat-input" placeholder="Digite sua pergunta">
                <button id="send-button" class="send-button">
                    <svg viewBox="0 0 24 24" width="24" height="24" fill="white"><path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path></svg>
                </button>
            </div>
        </footer>
    </div>
</div>

<style>
.lazo-popup-overlay {
    position: fixed;
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;
    background-color: transparent;
    backdrop-filter: none;
    display: none;
    justify-content: flex-end;
    align-items: center;
    padding: 0 30px;
    z-index: 2000;
    pointer-events: none;
}

.lazo-popup-overlay.active {
    display: flex;
}

:root {
    --background-color: #120c1ccf;
    --container-bg: #1a1129;
    --input-bg: #4b326f;
    --primary-purple: #a062ff;
    --border-glow: #6cff87; 
    --text-color: #f0f0f0;
    --text-secondary: #b3b3b3;
}

.chat-container {
    pointer-events: auto;
    width: 380px;
    max-width: 95vw;
    height: 80vh;
    max-height: 720px;
    background-color: #160f29;
    border: 1px solid #4A3A69;
    box-shadow: 0 10px 50px rgba(0, 0, 0, 0.3);
    border-radius: 24px;
    display: flex;
    flex-direction: column;
    animation: slideInFromRight 0.4s cubic-bezier(0.25, 1, 0.5, 1);
}

@keyframes slideInFromRight {
    from {
        opacity: 0;
        transform: translateX(30px);
    }
    to {
        opacity: 1;
        transform: translateX(0);
    }
}

@media (max-width: 600px) {
    .chat-container {
        width: 95vw;
        height: 80vh;
        max-height: 90vh;
    }
}

.chat-header {
    padding: 20px 25px;
    position: relative;
    flex-shrink: 0;
    border-bottom: 1px solid #2a1d42;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.header-content {
    display: flex;
    align-items: center;
    gap: 15px;
}

.close-button {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    border: 2px solid #5a5178;
    background-color: transparent;
    color: #988ec2;
    font-size: 20px;
    font-weight: bold;
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: all 0.3s ease;
    text-decoration: none; 
}

.close-button:hover {
    background-color: var(--border-glow);
    color: #160f29;
    border-color: var(--border-glow);
    transform: rotate(90deg);
}

.chat-header h1 {
    font-size: 22px;
    font-weight: 600;
    color: var(--text-color);
}

.mascot {
    position: static;
    width: 60px;
    height: 60px;
    animation: float 4s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0); }
    50% { transform: translateY(-8px); }
}

.chat-body {
    flex: 1;
    padding: 10px 15px 10px 25px;
    overflow-y: auto;
    display: flex;
    flex-direction: column;
}

.chat-body::-webkit-scrollbar {
    width: 6px;
}
.chat-body::-webkit-scrollbar-track {
    background: transparent;
}
.chat-body::-webkit-scrollbar-thumb {
    background-color: #4A3A69;
    border-radius: 6px;
}
.chat-body::-webkit-scrollbar-thumb:hover {
    background-color: #6c5b92;
}

.welcome-message {
    margin: auto;
    text-align: center;
    color: #c0b8d4;
    padding: 20px;
    opacity: 0.7;
}

.welcome-message h2 {
    color: #FFFFFF;
    font-size: 20px;
    margin-bottom: 5px;
}

.message {
    max-width: 85%;
    padding: 14px 20px;
    border-radius: 22px;
    margin-bottom: 12px;
    opacity: 0;
    transform: translateY(10px);
    animation: slideIn 0.5s forwards;
    color: #EAE6F5;
    word-wrap: break-word;
    line-height: 1.5;
}

@keyframes slideIn { to { opacity: 1; transform: translateY(0); } }

.user-message {
    background-color: var(--primary-purple);
    color: white;
    align-self: flex-end;
    border-bottom-right-radius: 8px;
}

.lazo-message {
    background-color: #2c1d44;
    color: #c0b8d4;
    align-self: flex-start;
    border-bottom-left-radius: 8px;
}

.typing-indicator {
    display: flex;
    align-items: center;
    align-self: flex-start;
    padding: 18px 20px;
}

.typing-indicator span {
    height: 9px;
    width: 9px;
    margin: 0 3px;
    background-color: #6c5b92;
    border-radius: 50%;
    display: inline-block;
    animation: bounce-typing 1.4s infinite ease-in-out both;
}

.typing-indicator span:nth-child(1) { animation-delay: -0.32s; }
.typing-indicator span:nth-child(2) { animation-delay: -0.16s; }

@keyframes bounce-typing {
    0%, 80%, 100% { transform: scale(0.5); opacity: 0.5; }
    40% { transform: scale(1.0); opacity: 1; }
}

.chat-footer {
    padding: 15px 25px 20px 25px;
    flex-shrink: 0;
    border-top: 1px solid #2a1d42;
}

.input-wrapper {
    display: flex;
    align-items: center;
    background-color: #160f29;
    border: 1px solid #4A3A69;
    border-radius: 18px;
    padding: 6px;
    transition: border-color 0.2s ease;
}

.input-wrapper:focus-within {
    border-color: var(--primary-purple);
}

#chat-input {
    flex: 1;
    border: none;
    background: transparent;
    color: white;
    font-size: 16px;
    padding: 10px 15px;
    outline: none;
}

#chat-input::placeholder {
    color: var(--text-secondary);
}

.send-button {
    width: 44px;
    height: 44px;
    border-radius: 14px;
    border: none;
    background-image: linear-gradient(45deg, #a062ff, #7a42d4);
    cursor: pointer;
    display: flex;
    justify-content: center;
    align-items: center;
    transition: transform 0.2s, box-shadow 0.2s;
}

.send-button:hover {
    transform: scale(1.05);
    box-shadow: 0 0 15px rgba(160, 98, 255, 0.5);
}

.send-button:active {
    transform: scale(0.95);
    transition: transform 0.1s;
}

.message.lazo-message ul,
.message.lazo-message ol {
    padding-left: 25px; 
    margin-top: 10px;   
    margin-bottom: 10px;
}

.message.lazo-message p {
    margin-bottom: 0.5em; 
}

.message.lazo-message p:last-child {
    margin-bottom: 0;
}

.message.lazo-message strong {
    color: #e0e0e0; 
}
</style>
