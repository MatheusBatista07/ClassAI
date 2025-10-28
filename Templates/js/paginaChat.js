document.addEventListener('DOMContentLoaded', function () {
    // =======================================================
    //            CONFIGURAÇÃO E ELEMENTOS GLOBAIS
    // =======================================================

    // --- Chaves do Pusher inseridas ---
    const PUSHER_KEY = '7c0e3086c3a3afbb1b08';
    const PUSHER_CLUSTER = 'us2';

    // Pega o ID do usuário logado do atributo no body
    const currentUserId = parseInt(document.body.dataset.userId, 10);
    let activeContactId = null; // Guarda o ID do contato da conversa ativa
    let pusherChannel = null;   // Guarda o canal do Pusher ativo

    // Elementos da interface (DOM)
    const contactsView = document.getElementById('contacts-view');
    const conversationView = document.getElementById('conversation-view');
    const messageList = document.getElementById('message-list');
    const messageInput = document.getElementById('message-input');
    const sendMessageBtn = document.getElementById('send-message-btn');
    const backButton = document.getElementById('back-to-contacts');
    const conversationAvatar = document.getElementById('conversation-avatar');
    const conversationName = document.getElementById('conversation-name');

    // Inicialização do Pusher
    const pusher = new Pusher(PUSHER_KEY, {
        cluster: PUSHER_CLUSTER
    });

    // =======================================================
    //            FUNÇÕES PRINCIPAIS DO CHAT
    // =======================================================

    /**
     * Adiciona uma mensagem na tela de chat.
     * @param {string} text - O conteúdo da mensagem.
     * @param {number} senderId - O ID de quem enviou.
     */
    function appendMessage(text, senderId) {
        const messageDiv = document.createElement('div');
        const messageType = senderId === currentUserId ? 'sent' : 'received';
        messageDiv.classList.add('message', messageType);
        messageDiv.textContent = text;
        messageList.appendChild(messageDiv);
        // Rola a tela para a última mensagem
        messageList.scrollTop = messageList.scrollHeight;
    }

    /**
     * Busca o histórico de mensagens da API e as exibe na tela.
     */
    async function fetchAndDisplayHistory() {
        messageList.innerHTML = '<div class="text-center text-muted p-3">Carregando histórico...</div>';
        try {
            // NOTA: Se o erro 404 persistir, tente usar o caminho absoluto: /classai/api.php
            const response = await fetch(`../api.php?action=getMessages&userId=${currentUserId}&contactId=${activeContactId}`);
            if (!response.ok) {
                // Se a resposta não for OK, tentamos ler como texto para ver o erro do PHP
                const errorText = await response.text();
                throw new Error(`Falha na API: Status ${response.status}. Resposta: ${errorText}`);
            }

            const messages = await response.json();
            messageList.innerHTML = ''; // Limpa a mensagem de "carregando"

            if (messages.length === 0) {
                messageList.innerHTML = '<div class="text-center text-muted p-3">Inicie a conversa!</div>';
            } else {
                messages.forEach(msg => {
                    appendMessage(msg.conteudo, parseInt(msg.id_remetente, 10));
                });
            }
        } catch (error) {
            console.error('Erro ao carregar histórico:', error);
            messageList.innerHTML = '<div class="text-center text-danger p-3">Não foi possível carregar as mensagens. Verifique o console (F12).</div>';
        }
    }

    /**
     * Envia uma nova mensagem para a API.
     */
    async function sendMessage() {
        const messageText = messageInput.value.trim();
        if (messageText === '' || !activeContactId) return;

        const tempMessage = messageText; // Guarda a mensagem para o caso de falha
        messageInput.value = '';

        try {
            // NOTA: Se o erro 404 persistir, tente usar o caminho absoluto: /classai/api.php
            await fetch('../api.php?action=sendMessage', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    senderId: currentUserId,
                    receiverId: activeContactId,
                    message: tempMessage
                })
            });
        } catch (error) {
            console.error('Erro ao enviar mensagem:', error);
            alert('Não foi possível enviar a mensagem.');
            messageInput.value = tempMessage; // Devolve o texto para o input em caso de erro
        }
    }

    /**
     * Se inscreve no canal do Pusher para a conversa atual e ouve por novas mensagens.
     */
    /**
     * Se inscreve no canal do Pusher para a conversa atual e ouve por novas mensagens.
     */
    function subscribeToChannel() {
        // ====================================================================
        // A ÚNICA MUDANÇA É AQUI: de 'private-chat-' para 'chat-'
        const channelName = `chat-${Math.min(currentUserId, activeContactId)}-${Math.max(currentUserId, activeContactId)}`;
        // ====================================================================

        pusherChannel = pusher.subscribe(channelName);

        pusherChannel.bind('new-message', (data) => {
            // Só adiciona a mensagem se ela for para esta conversa ativa
            if ((data.senderId === currentUserId && data.receiverId === activeContactId) ||
                (data.senderId === activeContactId && data.receiverId === currentUserId)) {
                appendMessage(data.message, data.senderId);
            }
        });
    }


    /**
     * Abre a janela de conversa ao clicar em um contato.
     */
    function openConversation(contactElement) {
        activeContactId = parseInt(contactElement.dataset.contactId, 10);

        conversationAvatar.src = contactElement.dataset.contactAvatar;
        conversationName.textContent = contactElement.dataset.contactName;

        fetchAndDisplayHistory();
        subscribeToChannel();

        contactsView.style.display = 'none';
        conversationView.style.display = 'flex';
        messageInput.focus();
    }

    /**
     * Fecha a conversa e volta para a lista de contatos.
     */
    function backToContacts() {
        if (pusherChannel) {
            pusher.unsubscribe(pusherChannel.name);
            pusherChannel = null;
        }

        activeContactId = null;
        contactsView.style.display = 'block';
        conversationView.style.display = 'none';
    }

    // =======================================================
    //            EVENT LISTENERS (Gatilhos de Ação)
    // =======================================================

    document.querySelectorAll('.chat-item').forEach(item => {
        item.addEventListener('click', () => openConversation(item));
    });

    backButton.addEventListener('click', backToContacts);
    sendMessageBtn.addEventListener('click', sendMessage);

    messageInput.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendMessage();
        }
    });

    const menuToggle = document.querySelector('.header_mobile .bi-list');
    if (menuToggle) {
        menuToggle.addEventListener('click', () => document.body.classList.toggle('sidebar-open'));
    }
});
