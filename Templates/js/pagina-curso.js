// script.js

document.addEventListener('DOMContentLoaded', function() {

    // --- 1. SIMULAÇÃO DO BANCO DE DADOS ---
    // Em uma aplicação real, estes dados viriam de uma API (ex: fetch('/api/cursos/1/modulos'))
    const modulosDoCurso = [
 

        // O cliente pode adicionar mais módulos aqui no banco de dados,
        // e eles aparecerão automaticamente na página!
    ];

    // --- 2. FUNÇÃO PARA GERAR E EXIBIR OS CARDS ---
    function carregarModulos( ) {
        const track = document.querySelector('.modules-track');
        
        // Limpa o container caso já tenha algo (bom para atualizações)
        track.innerHTML = '';

        // Itera sobre cada objeto do array de módulos
        modulosDoCurso.forEach((modulo, index) => {
            // Cria o HTML para um único card usando os dados do objeto 'modulo'
            const cardHTML = `
                <div class="module-card">
                    <div class="module-image-container">
                        <img src="${modulo.imagemUrl}" alt="${modulo.titulo}">
                    </div>
                    <div class="module-content">
                        <h3>Módulo ${index + 1} <i class="far fa-bookmark"></i></h3>
                        <p>${modulo.titulo}</p>
                        <span class="duration"><i class="far fa-clock"></i> Duração estimada: ${modulo.duracao}</span>
                    </div>
                </div>
            `;
            
            // Insere o HTML do card recém-criado dentro da 'track'
            track.insertAdjacentHTML('beforeend', cardHTML);
        });
    }

    // --- 3. EXECUÇÃO ---
    // Chama a função para carregar os módulos assim que a página estiver pronta
    carregarModulos();

    // Lógica do botão "Inscreva-se" que já tínhamos
    const ctaButton = document.querySelector('.cta-button');
    if (ctaButton) {
        ctaButton.addEventListener('click', function() {
            alert('Você clicou em Inscreva-se! A funcionalidade de inscrição pode ser implementada aqui.');
        });
    }
});

