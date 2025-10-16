// Script para a página de certificados
// Adicione suas funcionalidades JavaScript aqui

document.addEventListener('DOMContentLoaded', function() {
    console.log('Página de certificados carregada com sucesso!');
    
    // Exemplo: adicionar interatividade aos cards de certificados
    const certificateCards = document.querySelectorAll('.certificate-card');
    
    certificateCards.forEach(card => {
        card.addEventListener('click', function(e) {
            // Previne o clique se for no botão
            if (!e.target.closest('.certificate-action')) {
                console.log('Card clicado:', this.querySelector('.certificate-title').textContent);
            }
        });
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const closeMenuBtn = document.querySelector('.close-menu-btn');
    const body = document.body;

    if (menuToggle && closeMenuBtn && body) {
        // Abre o menu pop-up
        menuToggle.addEventListener('click', function() {
            body.classList.add('sidebar-open');
        });

        // Fecha o menu pop-up
        closeMenuBtn.addEventListener('click', function() {
            body.classList.remove('sidebar-open');
        });
    }
});


