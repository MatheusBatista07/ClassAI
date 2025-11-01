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

    const sitePresenceChannel = pusher.subscribe('presence-site');

    const updateOnlineStatus = (members) => {
        onlineUsers.clear();
        members.each(member => onlineUsers.add(parseInt(member.id, 10)));
        updateAllContactStatuses();
    };

    sitePresenceChannel.bind('pusher:subscription_succeeded', updateOnlineStatus);
    sitePresenceChannel.bind('pusher:member_added', () => sitePresenceChannel.trigger('pusher:subscription_succeeded', sitePresenceChannel.members));
    sitePresenceChannel.bind('pusher:member_removed', () => sitePresenceChannel.trigger('pusher:subscription_succeeded', sitePresenceChannel.members));

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

    document.querySelectorAll(".chat-item").forEach((item) => {
        item.addEventListener("click", () => openConversation(item));
    });
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
