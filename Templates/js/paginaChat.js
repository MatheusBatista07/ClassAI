document.addEventListener("DOMContentLoaded", function () {
    const PUSHER_KEY = "7c0e3086c3a3afbb1b08";
    const PUSHER_CLUSTER = "us2";
    const currentUserId = parseInt(document.body.dataset.userId, 10);

    let activeContactId = null;
    let conversationChannel = null;
    const onlineUsers = new Set();

    const contactsView = document.getElementById("contacts-view");
    const conversationView = document.getElementById("conversation-view");
    const messageList = document.getElementById("message-list");
    const messageInput = document.getElementById("message-input");
    const sendMessageBtn = document.getElementById("send-message-btn");
    const backButton = document.getElementById("back-to-contacts");
    const conversationAvatar = document.getElementById("conversation-avatar");
    const conversationName = document.getElementById("conversation-name");
    const statusElement = document.getElementById("conversation-status");

    const pusher = new Pusher(PUSHER_KEY, {
        cluster: PUSHER_CLUSTER,
        authEndpoint: '/ClassAI/api.php?action=pusherAuth'
    });

    const usersChannel = pusher.subscribe('canal-usuarios');

    usersChannel.bind('novo-usuario-cadastrado', function(data) {
        if (data.id === currentUserId) {
            return;
        }
        const existingContact = document.querySelector(`.chat-item[data-contact-id="${data.id}"]`);
        if (existingContact) {
            return;
        }
        adicionarNovoContatoNaTela(data);
    });

    function adicionarNovoContatoNaTela(contato) {
        const chatList = document.querySelector('.chat-list');
        if (!chatList) return;

        const emptyMessage = chatList.querySelector('.text-center');
        if (emptyMessage) {
            emptyMessage.remove();
        }

        const avatarUrl = contato.foto_perfil_url
            ? `/ClassAI/${contato.foto_perfil_url}`
            : `https://ui-avatars.com/api/?name=${encodeURIComponent(contato.nome )}&background=random`;

        const novoContatoDiv = document.createElement('div');
        novoContatoDiv.className = 'chat-item';
        novoContatoDiv.dataset.contactId = contato.id;
        novoContatoDiv.dataset.contactName = `${contato.nome} ${contato.sobrenome}`;
        novoContatoDiv.dataset.contactAvatar = avatarUrl;
        novoContatoDiv.dataset.contactStatus = 'offline';

        novoContatoDiv.innerHTML = `
            <div class="chat-avatar-container">
                <img src="${avatarUrl}" alt="Avatar de ${contato.nome}" class="chat-avatar">
                <div class="status-indicator"></div>
            </div>
            <div class="chat-info">
                <div class="chat-name">${contato.nome} ${contato.sobrenome}</div>
                <div class="chat-message">Clique para iniciar a conversa...</div>
            </div>
            <div class="chat-time"></div>
        `;

        chatList.prepend(novoContatoDiv);
    }

    const sitePresenceChannel = pusher.subscribe('presence-site');

    sitePresenceChannel.bind('pusher:subscription_succeeded', (members) => {
        onlineUsers.clear();
        members.each(member => onlineUsers.add(parseInt(member.id, 10)));
        updateAllContactStatuses();
    });

    sitePresenceChannel.bind('pusher:member_added', (member) => {
        onlineUsers.add(parseInt(member.id, 10));
        updateAllContactStatuses();
    });

    sitePresenceChannel.bind('pusher:member_removed', (member) => {
        onlineUsers.delete(parseInt(member.id, 10));
        updateAllContactStatuses();
    });

    function updateAllContactStatuses() {
        document.querySelectorAll('.chat-item').forEach(item => {
            const contactId = parseInt(item.dataset.contactId, 10);
            const isOnline = onlineUsers.has(contactId);
            
            item.dataset.contactStatus = isOnline ? 'online' : 'offline';

            if (contactId === activeContactId) {
                statusElement.textContent = isOnline ? 'Online' : 'Offline';
                statusElement.className = `chat-status ${isOnline ? 'online' : 'offline'}`;
            }
        });
    }

    function openConversation(contactElement) {
        activeContactId = parseInt(contactElement.dataset.contactId, 10);
        conversationAvatar.src = contactElement.dataset.contactAvatar;
        conversationName.textContent = contactElement.dataset.contactName;

        const isOnline = onlineUsers.has(activeContactId);
        statusElement.textContent = isOnline ? 'Online' : 'Offline';
        statusElement.className = `chat-status ${isOnline ? 'online' : 'offline'}`;

        fetchAndDisplayHistory();
        subscribeToConversationChannel();

        contactsView.style.display = "none";
        conversationView.style.display = "flex";
        messageInput.focus();
    }

    function subscribeToConversationChannel() {
        if (conversationChannel) {
            pusher.unsubscribe(conversationChannel.name);
        }
        const channelName = `private-chat-${Math.min(currentUserId, activeContactId)}-${Math.max(currentUserId, activeContactId)}`;
        conversationChannel = pusher.subscribe(channelName);

        conversationChannel.bind('new-message', (data) => {
            if ((parseInt(data.senderId, 10) === currentUserId && parseInt(data.receiverId, 10) === activeContactId) ||
                (parseInt(data.senderId, 10) === activeContactId && parseInt(data.receiverId, 10) === currentUserId)) {
                appendMessage(data.message, parseInt(data.senderId, 10));
            }
        });
    }
    
    async function sendMessage() {
        const messageText = messageInput.value.trim();
        if (messageText === "" || !activeContactId) return;

        const tempMessage = messageText;
        messageInput.value = "";

        const url = "/ClassAI/api.php?action=sendMessage";
        try {
            const response = await fetch(url, {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({
                    senderId: currentUserId,
                    receiverId: activeContactId,
                    message: tempMessage,
                }),
            });
            if (!response.ok) {
                const errorText = await response.text();
                throw new Error(`Falha na API: ${errorText}`);
            }
        } catch (error) {
            console.error("Erro ao enviar mensagem:", error);
            alert("Não foi possível enviar a mensagem.");
            messageInput.value = tempMessage;
        }
    }

    function backToContacts() {
        if (conversationChannel) {
            pusher.unsubscribe(conversationChannel.name);
            conversationChannel = null;
        }
        activeContactId = null;
        contactsView.style.display = "block";
        conversationView.style.display = "none";
    }

    function appendMessage(text, senderId) {
        const messageDiv = document.createElement("div");
        const messageType = senderId === currentUserId ? "sent" : "received";
        messageDiv.classList.add("message", messageType);
        messageDiv.textContent = text;
        messageList.appendChild(messageDiv);
        messageList.scrollTop = messageList.scrollHeight;
    }

    async function fetchAndDisplayHistory() {
        messageList.innerHTML = '<div class="text-center text-muted p-3">Carregando...</div>';
        const url = `/ClassAI/api.php?action=getMessages&userId=${currentUserId}&contactId=${activeContactId}`;
        try {
            const response = await fetch(url);
            if (!response.ok) throw new Error('Falha na API');
            const messages = await response.json();
            messageList.innerHTML = "";
            if (messages.length === 0) {
                messageList.innerHTML = '<div class="text-center text-muted p-3">Inicie a conversa!</div>';
            } else {
                messages.forEach(msg => appendMessage(msg.conteudo, parseInt(msg.id_remetente, 10)));
            }
        } catch (error) {
            console.error("Erro ao carregar histórico:", error);
            messageList.innerHTML = '<div class="text-center text-danger p-3">Erro ao carregar mensagens.</div>';
        }
    }

    const chatList = document.querySelector('.chat-list');
    if (chatList) {
        chatList.addEventListener('click', function(event) {
            const chatItem = event.target.closest('.chat-item');
            if (chatItem) {
                openConversation(chatItem);
            }
        });
    }

    backButton.addEventListener("click", backToContacts);
    sendMessageBtn.addEventListener("click", sendMessage);
    messageInput.addEventListener("keypress", (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            sendMessage();
        }
    });
    
    const menuToggle = document.querySelector(".header_mobile .bi-list");
    if (menuToggle) {
        menuToggle.addEventListener("click", () => document.body.classList.toggle("sidebar-open"));
    }
});
