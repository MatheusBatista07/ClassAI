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

