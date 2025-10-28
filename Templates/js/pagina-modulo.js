document.addEventListener('DOMContentLoaded', function() {

    // 1. Simulação de dados para um módulo específico
    const dadosDoModulo = {
        titulo: 'Fundamentos do ChatGPT e Aplicações no Dia a Dia',
        videos: [
            { id: 1, titulo: 'Aula 1' },
            { id: 2, titulo: 'Aula 2' },
            { id: 3, titulo: 'Aula 3' },
            { id: 4, titulo: 'Aula 4' }
        ],
        materiais: [
            { id: 1, nome: 'Prompt Da Aula 1', url: '#' },
            { id: 2, nome: 'Guia de Prompt', url: '#' },
            { id: 3, nome: 'Atividade Prática - 01', url: '#' },
            { id: 4, nome: 'Prompt Da Aula 2', url: '#' },
            { id: 5, nome: 'Atividade Prática - 02', url: '#' }
        ]
    };

    // 2. Referências aos elementos do HTML
    const lessonHeader = document.querySelector('.lesson-header');
    const videoListContainer = document.getElementById('video-list');
    const materialsListContainer = document.getElementById('materials-list');

    // 3. Função para carregar todo o conteúdo da página
    function carregarConteudo() {
        if (!lessonHeader || !videoListContainer || !materialsListContainer) {
            console.error('Elementos essenciais da página de aula não foram encontrados.');
            return;
        }

        // Carrega o título do módulo
        lessonHeader.innerHTML = `<h1>${dadosDoModulo.titulo}</h1>`;

        // Limpa os containers antes de adicionar novo conteúdo
        videoListContainer.innerHTML = '';
        materialsListContainer.innerHTML = '';

        // Carrega os vídeos
        dadosDoModulo.videos.forEach(video => {
            const videoHTML = `
                <div class="video-placeholder" data-video-id="${video.id}">
                    <i class="fas fa-play play-icon"></i>
                </div>
            `;
            videoListContainer.insertAdjacentHTML('beforeend', videoHTML);
        });

        // Carrega os materiais
        dadosDoModulo.materiais.forEach(material => {
            const materialHTML = `
                <a href="${material.url}" class="material-item" download>
                    <i class="fas fa-download download-icon"></i>
                    <span>${material.nome}</span>
                </a>
            `;
            materialsListContainer.insertAdjacentHTML('beforeend', materialHTML);
        });
    }

    // 4. Inicia o carregamento do conteúdo
    carregarConteudo();

});
