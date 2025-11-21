document.addEventListener("DOMContentLoaded", function () {
    const currentUserId = document.body.dataset.userId || document.getElementById('global-user-data')?.dataset.userId;

    if (!currentUserId) {
        return;
    }

    const PUSHER_KEY = "d9bd3f6127b8b54b7cc8";
    const PUSHER_CLUSTER = "sa1";
    const AUTH_ENDPOINT = '/ClassAI/api.php?action=pusherAuth';

    try {
        Pusher.logToConsole = false;

        window.pusher = new Pusher(PUSHER_KEY, {
            cluster: PUSHER_CLUSTER,
            authEndpoint: AUTH_ENDPOINT,
            auth: { params: { user_id: currentUserId } }
        });

        const presenceChannel = window.pusher.subscribe('presence-classai-global');

        presenceChannel.bind('pusher:subscription_succeeded', (members) => {
            console.log(`Pusher: Conectado! ${members.count} membro(s) online.`);
            
            window.onlineUsers = new Set();
            members.each(member => {
                if (member.id !== currentUserId) {
                    window.onlineUsers.add(parseInt(member.id, 10));
                }
            });
            updateVisualStatus();
        });

        presenceChannel.bind('pusher:subscription_error', (status) => {
            console.error("Pusher: Falha na inscrição. Status:", status);
        });

        presenceChannel.bind('pusher:member_added', (member) => {
            window.onlineUsers.add(parseInt(member.id, 10));
            updateVisualStatus();
        });

        presenceChannel.bind('pusher:member_removed', (member) => {
            window.onlineUsers.delete(parseInt(member.id, 10));
            updateVisualStatus();
        });

    } catch (e) {
        console.error("Pusher: Erro crítico ao instanciar:", e);
    }

    function updateVisualStatus() {
        const displayedUsers = document.querySelectorAll('[data-contact-id]');

        displayedUsers.forEach(element => {
            const contactId = element.dataset.contactId;
            const isOnline = window.onlineUsers.has(parseInt(contactId, 10));
            const statusIndicator = document.getElementById(`status-indicator-${contactId}`);

            if (statusIndicator) {
                statusIndicator.style.backgroundColor = isOnline ? '#22c55e' : '#6c757d';
            }

            if (element.hasAttribute('data-contact-status')) {
                element.dataset.contactStatus = isOnline ? 'online' : 'offline';
            }
        });

        const conversationStatusElement = document.getElementById("conversation-status");
        if (conversationStatusElement) {
            const activeContactId = parseInt(document.body.dataset.activeContactId, 10);
            if (activeContactId && !isNaN(activeContactId)) {
                const isOnline = window.onlineUsers.has(activeContactId);
                conversationStatusElement.textContent = isOnline ? 'Online' : 'Offline';
                conversationStatusElement.className = `chat-status ${isOnline ? 'online' : 'offline'}`;
            }
        }
    }

    const logoutLink = document.getElementById('logout-link');
    if (logoutLink) {
        logoutLink.addEventListener('click', function (e) {
            e.preventDefault();
            if (window.pusher) {
                window.pusher.disconnect();
            }
            setTimeout(() => { window.location.href = this.href; }, 150);
        });
    }

    window.triggerVisualStatusUpdate = updateVisualStatus;
});
