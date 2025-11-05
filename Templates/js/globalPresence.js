
document.addEventListener("DOMContentLoaded", function () {
    const currentUserId = document.body.dataset.userId;
    if (!currentUserId) return;

    const PUSHER_KEY = "7c0e3086c3a3afbb1b08";
    const PUSHER_CLUSTER = "us2";
    
    window.onlineUsers = new Set();

    const pusher = new Pusher(PUSHER_KEY, {
        cluster: PUSHER_CLUSTER,
        authEndpoint: '/ClassAI/api.php?action=pusherAuth'
    });

    const sitePresenceChannel = pusher.subscribe('presence-site');

    function updateVisualStatus() {
        document.querySelectorAll('.chat-item[data-contact-status]').forEach(item => {
            const contactId = parseInt(item.dataset.contactId, 10);
            const isOnline = window.onlineUsers.has(contactId);
            
            item.dataset.contactStatus = isOnline ? 'online' : 'offline';
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

    sitePresenceChannel.bind('pusher:subscription_succeeded', (members) => {
        window.onlineUsers.clear();
        members.each(member => window.onlineUsers.add(parseInt(member.id, 10)));
        updateVisualStatus();
    });

    sitePresenceChannel.bind('pusher:member_added', (member) => {
        window.onlineUsers.add(parseInt(member.id, 10));
        updateVisualStatus();
    });

    sitePresenceChannel.bind('pusher:member_removed', (member) => {
        window.onlineUsers.delete(parseInt(member.id, 10));
        updateVisualStatus();
    });

    const logoutLink = document.getElementById('logout-link');
    if (logoutLink) {
        logoutLink.addEventListener('click', function(e) {
            e.preventDefault();
            pusher.disconnect();
            setTimeout(() => { window.location.href = this.href; }, 100);
        });
    }
    
    window.triggerVisualStatusUpdate = updateVisualStatus;
});
