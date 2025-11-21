document.addEventListener('DOMContentLoaded', function() {
    const userDataDiv = document.getElementById('global-user-data');
    if (!userDataDiv) return;

    const userId = userDataDiv.dataset.userId;
    const pusherKey = userDataDiv.dataset.pusherKey;
    const pusherCluster = userDataDiv.dataset.pusherCluster;

    if (!userId || !pusherKey || !pusherCluster) {
        console.error("Dados do usuário ou do Pusher não encontrados para o sistema de notificações.");
        return;
    }

    const bellIcon = document.getElementById('notificationBell');
    const panel = document.getElementById('notificationPanel');
    const badge = document.getElementById('notificationBadge');
    const notificationList = document.getElementById('notificationList');
    const markAllAsReadBtn = document.getElementById('markAllAsRead');

    const fetchNotifications = async () => {
        try {
            const response = await fetch('/ClassAI/notifications_api.php?action=fetch');
            if (!response.ok) throw new Error('Falha na resposta da rede ao buscar notificações.');
            
            const data = await response.json();
            updateNotificationUI(data.notifications, data.unread_count);
        } catch (error) {
            console.error('Erro ao buscar notificações:', error);
            notificationList.innerHTML = '<div class="notification-placeholder"><p>Erro ao carregar notificações.</p></div>';
        }
    };

    const updateNotificationUI = (notifications, unreadCount) => {
        if (unreadCount > 0) {
            badge.textContent = unreadCount > 9 ? '9+' : unreadCount;
            badge.style.display = 'block';
        } else {
            badge.style.display = 'none';
        }

        notificationList.innerHTML = '';
        if (notifications && notifications.length > 0) {
            notifications.forEach(notif => {
                const item = document.createElement('div');
                item.className = `notification-item ${!notif.lida ? 'unread' : ''}`;
                const link = document.createElement('a');
                link.href = notif.link || '#';
                link.textContent = notif.mensagem;
                item.appendChild(link);
                notificationList.appendChild(item);
            });
        } else {
            notificationList.innerHTML = '<div class="notification-placeholder"><p>Você não tem notificações.</p></div>';
        }
    };

    bellIcon.addEventListener('click', (event) => {
        event.stopPropagation();
        const isActive = panel.classList.toggle('active');
        if (isActive) {
            fetchNotifications();
        }
    });

    window.addEventListener('click', (event) => {
        if (panel && !panel.contains(event.target) && !bellIcon.contains(event.target)) {
            panel.classList.remove('active');
        }
    });

    markAllAsReadBtn.addEventListener('click', async () => {
        badge.style.display = 'none';
        try {
            await fetch('/ClassAI/notifications_api.php?action=mark_all_read', { method: 'POST' });
            fetchNotifications();
        } catch (error) {
            console.error('Erro ao marcar notificações como lidas:', error);
        }
    });

    const pusher = new Pusher(pusherKey, {
        cluster: pusherCluster,
        encrypted: true
    });

    const channelName = `notifications-user-${userId}`;
    const channel = pusher.subscribe(channelName);

    channel.bind('new-notification', function(data) {
        console.log('Nova notificação recebida via Pusher:', data);
        
        let currentCount = parseInt(badge.textContent) || 0;
        if (badge.style.display === 'none') currentCount = 0;
        
        const newCount = currentCount + 1;
        badge.textContent = newCount > 9 ? '9+' : newCount;
        badge.style.display = 'block';

        if (panel.classList.contains('active')) {
            fetchNotifications();
        }
    });

    fetchNotifications();
});
