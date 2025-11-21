document.addEventListener('DOMContentLoaded', function() {
    // --- Lógica para o Popup de Perfil ---
    const profileIcon = document.getElementById('user-profile-icon');
    const profilePopup = document.getElementById('profile-popup');

    if (profileIcon && profilePopup) {
        profileIcon.addEventListener('click', function(event) {
            event.stopPropagation();
            profilePopup.classList.toggle('show');
        });

        window.addEventListener('click', function(event) {
            if (profilePopup && !profilePopup.contains(event.target) && !profileIcon.contains(event.target)) {
                profilePopup.classList.remove('show');
            }
        });
    }

    // --- Lógica para o Popup do Lazzo ---
    const lazoPopupButton = document.getElementById('lazo-popup-button');
    const lazoPopupOverlay = document.getElementById('lazo-popup-overlay');
    const lazoCloseButton = document.getElementById('lazo-close-button');

    if (lazoPopupButton && lazoPopupOverlay) {
        lazoPopupButton.addEventListener('click', function() {
            lazoPopupOverlay.classList.add('active');
        });

        if (lazoCloseButton) {
            lazoCloseButton.addEventListener('click', function() {
                lazoPopupOverlay.classList.remove('active');
            });
        }

        lazoPopupOverlay.addEventListener('click', function(event) {
            if (event.target === lazoPopupOverlay) {
                lazoPopupOverlay.classList.remove('active');
            }
        });
    }
});
