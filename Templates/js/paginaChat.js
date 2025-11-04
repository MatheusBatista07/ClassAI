document.addEventListener("DOMContentLoaded", function () {
    const PUSHER_KEY = "7c0e3086c3a3afbb1b08";
    const PUSHER_CLUSTER = "us2";
    const currentUserId = parseInt(document.body.dataset.userId, 10);

    let activeContactId = null;
    let conversationChannel = null;
    const onlineUsers = new Set();
    let typingTimeout = null;

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

    const myPersonalChannelName = `private-chat-user-${currentUserId}`;
    const myPersonalChannel = pusher.subscribe(myPersonalChannelName);

    myPersonalChannel.bind('new-message', function(data) {
        const senderId = parseInt(data.senderId, 10);

        if (senderId === activeContactId) {
            appendMessage(data.message, senderId, data.timestamp);
        }else {
    const contactItem = document.querySelector(`.chat-item[data-contact-id="${senderId}"]`);
    if (contactItem) {
        const unreadBadge = contactItem.querySelector('.unread-count');
        if (unreadBadge) {
            let currentCount = unreadBadge.textContent === '99+' ? 99 : (parseInt(unreadBadge.textContent, 10) || 0);
            currentCount++;
            unreadBadge.textContent = currentCount > 99 ? '99+' : currentCount;
            unreadBadge.style.display = 'inline-block';
        }
    }
}
        updateContactListPreview(senderId, data.message, data.timestamp);
    });

    const usersChannel = pusher.subscribe('canal-usuarios');
    usersChannel.bind('novo-usuario-cadastrado', function(data) {
        if (data.id === currentUserId || document.querySelector(`.chat-item[data-contact-id="${data.id}"]`)) {
            return;
        }
        adicionarNovoContatoNaTela(data);
    });

    function adicionarNovoContatoNaTela(contato) {
        const chatList = document.querySelector('.chat-list');
        if (!chatList) return;
        const emptyMessage = chatList.querySelector('.text-center');
        if (emptyMessage) emptyMessage.remove();

        const avatarUrl = contato.foto_perfil_url ? `/ClassAI/${contato.foto_perfil_url}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(contato.nome )}&background=random`;
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
            <div class="chat-meta">
                <div class="chat-time"></div>
                <span class="unread-count" style="display: none;">0</span>
            </div>`;
        chatList.prepend(novoContatoDiv);
    }

    function updateContactListPreview(contactId, message, timestamp) {
        const chatList = document.querySelector('.chat-list');
        if (!chatList) return;
        const contactItem = chatList.querySelector(`.chat-item[data-contact-id="${contactId}"]`);
        if (!contactItem) return;
        const messageElement = contactItem.querySelector('.chat-message');
        const timeElement = contactItem.querySelector('.chat-time');
        if (messageElement) {
            messageElement.textContent = message.length > 30 ? message.substring(0, 30) + '...' : message;
        }
        if (timeElement && timestamp) {
            const date = new Date(timestamp);
            timeElement.textContent = date.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
        }
        chatList.prepend(contactItem);
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
        });
        if (activeContactId) {
            updateConversationStatus();
        }
    }

    function updateConversationStatus() {
        if (!activeContactId) return;
        const isOnline = onlineUsers.has(activeContactId);
        statusElement.textContent = isOnline ? 'Online' : 'Offline';
        statusElement.className = `chat-status ${isOnline ? 'online' : 'offline'}`;
    }

    function openConversation(contactElement) {
        const unreadBadge = contactElement.querySelector('.unread-count');
        if (unreadBadge) {
            unreadBadge.textContent = '0';
            unreadBadge.style.display = 'none';
        }
        activeContactId = parseInt(contactElement.dataset.contactId, 10);
        conversationAvatar.src = contactElement.dataset.contactAvatar;
        conversationName.textContent = contactElement.dataset.contactName;
        updateConversationStatus();
        fetchAndDisplayHistory();
        subscribeToTypingChannel();
        contactsView.style.display = "none";
        conversationView.style.display = "flex";
        messageInput.focus();
    }

    function subscribeToTypingChannel() {
        if (conversationChannel) {
            conversationChannel.unbind_all();
            pusher.unsubscribe(conversationChannel.name);
        }
        const channelName = `presence-conversation-${Math.min(currentUserId, activeContactId)}-${Math.max(currentUserId, activeContactId)}`;
        conversationChannel = pusher.subscribe(channelName);

        conversationChannel.bind('client-typing', (data) => {
            if (data.senderId === activeContactId) {
                statusElement.textContent = 'Digitando...';
            }
        });
        conversationChannel.bind('client-stop-typing', (data) => {
            if (data.senderId === activeContactId) {
                updateConversationStatus();
            }
        });
    }
    
    async function sendMessage() {
        const messageText = messageInput.value.trim();
        if (messageText === "" || !activeContactId) return;

        const timestamp = new Date().toISOString();
        appendMessage(messageText, currentUserId, timestamp);
        updateContactListPreview(activeContactId, messageText, timestamp);

        const tempMessage = messageText;
        messageInput.value = "";

        try {
            await fetch("/ClassAI/api.php?action=sendMessage", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ 
                    senderId: currentUserId, 
                    receiverId: activeContactId, 
                    message: tempMessage,
                    socket_id: pusher.connection.socket_id
                }),
            });
        } catch (error) {
            console.error("Erro ao enviar mensagem:", error);
            alert("Não foi possível enviar a mensagem.");
            messageInput.value = tempMessage;
        }
    }

    function backToContacts() {
        if (conversationChannel) {
            conversationChannel.unbind_all();
            pusher.unsubscribe(conversationChannel.name);
            conversationChannel = null;
        }
        activeContactId = null;
        contactsView.style.display = "block";
        conversationView.style.display = "none";
    }

    function appendMessage(text, senderId, timestamp) {
        const messageWrapper = document.createElement("div");
        const messageDiv = document.createElement("div");
        const timeDiv = document.createElement("div");
        const messageType = senderId === currentUserId ? "sent" : "received";
        messageWrapper.classList.add("message-wrapper", messageType);
        messageDiv.classList.add("message");
        messageDiv.textContent = text;
        timeDiv.classList.add("message-time");
        if (timestamp) {
            const date = new Date(timestamp);
            timeDiv.textContent = date.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
        }
        messageWrapper.appendChild(messageDiv);
        messageWrapper.appendChild(timeDiv);
        messageList.appendChild(messageWrapper);
        messageList.scrollTop = messageList.scrollHeight;
    }

    async function fetchAndDisplayHistory() {
        messageList.innerHTML = '<div class="text-center text-muted p-3">Carregando...</div>';
        const url = `/ClassAI/api.php?action=getMessages&contactId=${activeContactId}`;
        try {
            const response = await fetch(url);
            if (!response.ok) throw new Error('Falha na API');
            const messages = await response.json();
            messageList.innerHTML = "";
            if (messages.length === 0) {
                messageList.innerHTML = '<div class="text-center text-muted p-3">Inicie a conversa!</div>';
            } else {
               messages.forEach(msg => appendMessage(msg.conteudo, parseInt(msg.id_remetente, 10), msg.timestamp));
            }
        } catch (error) {
            console.error("Erro ao carregar histórico:", error);
            messageList.innerHTML = '<div class="text-center text-danger p-3">Erro ao carregar mensagens.</div>';
        }
    }

    function handleTyping() {
        if (!conversationChannel || !conversationChannel.subscribed) {
            return;
        }
        clearTimeout(typingTimeout);
        conversationChannel.trigger('client-typing', { senderId: currentUserId });
        typingTimeout = setTimeout(() => {
            conversationChannel.trigger('client-stop-typing', { senderId: currentUserId });
        }, 1500);
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
    
    messageInput.addEventListener('keyup', handleTyping);

    const menuToggle = document.querySelector(".header_mobile .bi-list");
    if (menuToggle) {
        menuToggle.addEventListener("click", () => document.body.classList.toggle("sidebar-open"));
    }
});
