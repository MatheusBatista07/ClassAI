document.addEventListener('DOMContentLoaded', () => {
    const contactsView = document.getElementById('contacts-view');
    const conversationView = document.getElementById('conversation-view');
    const backButton = document.getElementById('back-to-contacts');
    const messageList = document.getElementById('message-list');
    const messageInput = document.getElementById('message-input');
    const sendMessageBtn = document.getElementById('send-message-btn');
    const chatList = document.querySelector('.chat-list');

    const currentUserId = document.body.dataset.userId;
    let activeContactId = null;
    let pusher = null;

    function initializePusher() {
        const userDataDiv = document.getElementById('global-user-data');
        if (!userDataDiv || !window.Pusher) return;

        const pusherKey = userDataDiv.dataset.pusherKey;
        const pusherCluster = userDataDiv.dataset.pusherCluster;

        if (!pusherKey || !pusherCluster) return;

        pusher = new Pusher(pusherKey, {
            cluster: pusherCluster,
            authEndpoint: '/ClassAI/api.php?action=pusherAuth'
        });

        const privateChannelName = `private-chat-user-${currentUserId}`;
        const channel = pusher.subscribe(privateChannelName);

        channel.bind('new-message', function(data) {
            if (activeContactId && String(data.senderId) === String(activeContactId)) {
                appendMessage(data.message, 'received', data.timestamp);
                markMessagesAsRead(activeContactId); 
            } else {
                updateContactItem(data.senderId, data.message, true);
            }
        });
    }

    function updateContactItem(contactId, message, isNew) {
        const contactItem = chatList.querySelector(`.chat-item[data-contact-id='${contactId}']`);
        if (!contactItem) {
            location.reload();
            return;
        }

        const messageElement = contactItem.querySelector('.chat-message');
        if (messageElement) {
            messageElement.textContent = message.length > 25 ? message.substring(0, 25) + '...' : message;
        }

        if (isNew) {
            const unreadBadge = contactItem.querySelector('.unread-count');
            if (unreadBadge) {
                let currentCount = parseInt(unreadBadge.textContent) || 0;
                if (unreadBadge.style.display === 'none') currentCount = 0;
                const newCount = currentCount + 1;
                unreadBadge.textContent = newCount > 99 ? '99+' : newCount;
                unreadBadge.style.display = 'inline-block';
            }
        }
        
        if (chatList.firstChild !== contactItem) {
            chatList.prepend(contactItem);
        }
    }

    async function markMessagesAsRead(contactId) {
        const contactItem = chatList.querySelector(`.chat-item[data-contact-id='${contactId}']`);
        if (contactItem) {
            const unreadBadge = contactItem.querySelector('.unread-count');
            if (unreadBadge) {
                unreadBadge.style.display = 'none';
                unreadBadge.textContent = '0';
            }
        }

        try {
            await fetch('/ClassAI/api.php?action=mark_as_read', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ contactId: contactId })
            });
        } catch (error) {
            console.error('Falha ao marcar mensagens como lidas:', error);
        }
    }

    async function loadMessages(contactId) {
        messageList.innerHTML = '<div class="text-center p-5">Carregando mensagens...</div>';
        try {
            const response = await fetch(`/ClassAI/api.php?action=getMessages&contactId=${contactId}`);
            const messages = await response.json();
            messageList.innerHTML = '';
            messages.forEach(msg => {
                const side = String(msg.id_remetente) === String(currentUserId) ? 'sent' : 'received';
                appendMessage(msg.conteudo, side, msg.timestamp);
            });
        } catch (error) {
            messageList.innerHTML = '<div class="text-center p-5">Erro ao carregar mensagens.</div>';
        }
    }

    function appendMessage(text, side, timestamp) {
        const wrapper = document.createElement('div');
        wrapper.className = `message-wrapper ${side}`;

        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${side}`;
        messageDiv.textContent = text;

        const timeDiv = document.createElement('div');
        timeDiv.className = 'message-time';
        if (timestamp) {
            timeDiv.textContent = new Date(timestamp).toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
        }

        wrapper.appendChild(messageDiv);
        wrapper.appendChild(timeDiv);
        messageList.appendChild(wrapper);
        messageList.scrollTop = messageList.scrollHeight;
    }

    async function sendMessage() {
        const messageText = messageInput.value.trim();
        if (!messageText || !activeContactId) return;

        appendMessage(messageText, 'sent', new Date().toISOString());
        updateContactItem(activeContactId, messageText, false);
        messageInput.value = '';

        try {
            await fetch('/ClassAI/api.php?action=sendMessage', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    senderId: currentUserId,
                    receiverId: activeContactId,
                    message: messageText,
                    socket_id: pusher ? pusher.connection.socket_id : null
                })
            });
        } catch (error) {
            console.error('Erro ao enviar mensagem:', error);
        }
    }

    chatList.addEventListener('click', (e) => {
        const contactItem = e.target.closest('.chat-item');
        if (!contactItem) return;

        activeContactId = contactItem.dataset.contactId;
        
        const contactName = contactItem.dataset.contactName;
        const contactAvatar = contactItem.dataset.contactAvatar;
        const contactStatus = contactItem.dataset.contactStatus;

        document.getElementById('conversation-name').textContent = contactName;
        document.getElementById('conversation-avatar').src = contactAvatar;
        
        const statusElement = document.getElementById('conversation-status');
        statusElement.textContent = contactStatus.charAt(0).toUpperCase() + contactStatus.slice(1);
        statusElement.className = `chat-status ${contactStatus}`;
        
        contactsView.style.display = 'none';
        conversationView.style.display = 'flex';

        loadMessages(activeContactId);
        markMessagesAsRead(activeContactId);
    });

    backButton.addEventListener('click', () => {
        location.reload();
    });

    sendMessageBtn.addEventListener('click', sendMessage);
    messageInput.addEventListener('keydown', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendMessage();
        }
    });

    initializePusher();
});
