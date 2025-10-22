document.addEventListener('DOMContentLoaded', function() {

    // LÓGICA DOS MÓDULOS DO CURSO
    const modulosDoCurso = [];
    function carregarModulos() {
        const track = document.querySelector('.modules-track');
        if (track) {
            track.innerHTML = '';
            modulosDoCurso.forEach((modulo, index) => {
                const cardHTML = `...`; // O seu código aqui está correto
                track.insertAdjacentHTML('beforeend', cardHTML);
            });
        }
    }
    carregarModulos();

    const ctaButton = document.querySelector('.cta-button');
    if (ctaButton) {
        ctaButton.addEventListener('click', function() {
            alert('Você clicou em Inscreva-se! A funcionalidade de inscrição pode ser implementada aqui.');
        });
    }

    // LÓGICA DE NOTIFICAÇÕES
    const notificationBell = document.getElementById('notification-bell');
    const notificationPopup = document.getElementById('notifications-popup');
    const notificationDot = document.getElementById('notification-dot');
    const notificationList = document.getElementById('notification-list');
    const todasBadge = document.getElementById('todas-badge');

    if (!notificationBell || !notificationPopup || !notificationDot || !notificationList || !todasBadge) {
        console.warn("Elementos de notificação não encontrados. A funcionalidade está desativada.");
        return;
    }

    const mockDatabase = {
        notifications: [
            { id: 1, type: 'bem-vindo', title: 'Bem-vindo(a) ao ClassAI!', message: 'Sua jornada em Inteligência Artificial começa agora! Acesse seu curso de introdução e descubra como a IA pode transformar sua carreira.', linkText: 'Clique para começar!', timestamp: Date.now(), viewed: false },
        ]
    };

    function renderNotifications(notifications) {
        notificationList.innerHTML = '';
        if (notifications.length === 0) {
            notificationList.innerHTML = '<p style="text-align: center; color: var(--text-muted); padding: 20px;">Nenhuma notificação por aqui.</p>';
            return;
        }
        notifications.forEach(notif => {
            const iconClass = { 'bem-vindo': 'fa-solid fa-party-horn', 'curso': 'fa-solid fa-graduation-cap', 'feedback': 'fa-solid fa-star', 'mensagem': 'fa-solid fa-comment-dots' }[notif.type] || 'fa-solid fa-bell';
            const notificationCardHTML = `
                <div class="notification-card">
                    <div class="notification-card-header"><i class="${iconClass}"></i><span>${notif.title}</span></div>
                    <p>${notif.message}</p>
                    <a href="#" class="notification-card-link"><i class="fa-solid fa-arrow-right-to-bracket"></i><span>${notif.linkText}</span></a>
                </div>`;
            notificationList.insertAdjacentHTML('beforeend', notificationCardHTML);
        });
    }

    function manageNotifications() {
        const now = Date.now();
        const fortyEightHoursAgo = now - (3600 * 1000 * 48);
        mockDatabase.notifications = mockDatabase.notifications.filter(notif => notif.timestamp > fortyEightHoursAgo);
        const unreadNotifications = mockDatabase.notifications.filter(notif => !notif.viewed);
        notificationDot.style.display = unreadNotifications.length > 0 ? 'block' : 'none';
        todasBadge.textContent = mockDatabase.notifications.length;
        renderNotifications([...mockDatabase.notifications].reverse());
    }

    function togglePopup() {
        const isHidden = notificationPopup.style.display === 'none' || notificationPopup.style.display === '';
        if (isHidden) {
            notificationPopup.style.display = 'flex';
            mockDatabase.notifications.forEach(notif => notif.viewed = true);
            manageNotifications();
        } else {
            notificationPopup.style.display = 'none';
        }
    }

    notificationBell.addEventListener('click', function(event) {
        event.stopPropagation();
        togglePopup();
    });

    document.addEventListener('click', function(event) {
        if (!notificationPopup.contains(event.target) && event.target !== notificationBell) {
            notificationPopup.style.display = 'none';
        }
    });

    manageNotifications();
});
