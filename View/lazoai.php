
<button id="open-chatbot-btn" class="chatbot-open-button">
    <img src="<?php echo BASE_URL; ?>images/lazo_mascot.png" alt="Abrir Chat" />
</button>

<div class="chat-container" id="chatbot-container" style="display: none;">
    <header class="chat-header">
        <div class="header-content">
            <a href="#" id="chatbot-close-btn" class="close-button">&times;</a>
            <h1>Lazo AI</h1>
        </div>
        <img src="<?php echo BASE_URL; ?>images/lazo_mascot.png" alt="Mascote Lazo AI" class="mascot">
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

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script src="<?php echo BASE_URL; ?>templates/js/lazoai.js"></script>
