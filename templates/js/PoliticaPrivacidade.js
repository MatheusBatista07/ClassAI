document.addEventListener('DOMContentLoaded', () => {
    // --- LÓGICA DAS ABAS ---
    const privacyButton = document.getElementById('btn-privacy');
    const termsButton = document.getElementById('btn-terms');
    const privacySection = document.getElementById('privacy');
    const termsSection = document.getElementById('terms');
    const contentContainer = document.querySelector('.content');

    function showSection(sectionToShow, buttonToActivate) {
        privacySection.classList.remove('active');
        termsSection.classList.remove('active');
        privacyButton.classList.remove('active');
        termsButton.classList.remove('active');

        sectionToShow.classList.add('active');
        buttonToActivate.classList.add('active');
        
        contentContainer.scrollTop = 0;
    }

    privacyButton.addEventListener('click', () => showSection(privacySection, privacyButton));
    termsButton.addEventListener('click', () => showSection(termsSection, termsButton));

    // --- INICIALIZAÇÃO DO PARTICLES.JS ---
    particlesJS('particles-js', {
        "particles": {
            "number": { "value": 60, "density": { "enable": true, "value_area": 800 } },
            "color": { "value": "#8e44ad" },
            "shape": { "type": "circle" },
            "opacity": { "value": 0.4, "random": true, "anim": { "enable": true, "speed": 1, "opacity_min": 0.1, "sync": false } },
            "size": { "value": 3, "random": true, "anim": { "enable": false } },
            "line_linked": { "enable": true, "distance": 150, "color": "#8e44ad", "opacity": 0.2, "width": 1 },
            "move": { "enable": true, "speed": 2, "direction": "none", "random": false, "straight": false, "out_mode": "out", "bounce": false }
        },
        "interactivity": {
            "detect_on": "canvas",
            "events": { "onhover": { "enable": true, "mode": "grab" }, "onclick": { "enable": false }, "resize": true },
            "modes": { "grab": { "distance": 140, "line_linked": { "opacity": 0.5 } } }
        },
        "retina_detect": true
    });
});
