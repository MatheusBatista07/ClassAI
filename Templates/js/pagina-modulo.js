// No arquivo: pagina-aula.js

document.addEventListener('DOMContentLoaded', function() {

    // ========================================================================
    // PASSO 1: SIMULAR UM BANCO DE DADOS CENTRAL
    // Em um projeto real, isso viria de um servidor. Aqui, temos todos os
    // dados dos módulos em um único lugar para consulta.
    // ========================================================================
    const database = {
        1: { // Dados para o módulo com id=1
            titulo: 'Fundamentos do ChatGPT e Aplicações no Dia a Dia',
            videos: [
                { id: 1, titulo: 'Aula 1: Introdução' },
                { id: 2, titulo: 'Aula 2: Comandos Básicos' },
                { id: 3, titulo: 'Aula 3: Engenharia de Prompt' },
                { id: 4, titulo: 'Aula 4: Casos de Uso' }
            ],
            materiais: [
                { id: 1, nome: 'Prompt Da Aula 1', url: '#' },
                { id: 2, nome: 'Guia de Prompt', url: '#' },
                { id: 3, nome: 'Atividade Prática - 01', url: '#' }
            ]
        },
        2: { // Dados para o módulo com id=2
            titulo: 'Automatizando Tarefas com Texto e Criatividade',
            videos: [
                { id: 1, titulo: 'Introdução à Automação' },
                { id: 2, titulo: 'Criando Scripts de E-mail' }
            ],
            materiais: [
                { id: 1, nome: 'Modelos de E-mail para Automação', url: '#' },
                { id: 2, nome: 'Exercício Prático de Automação', url: '#' }
            ]
        },
        3: { // Dados para o módulo com id=3
            titulo: 'Organização Pessoal e Produtividade com a IA',
            videos: [
                { id: 1, titulo: 'Gerenciando Tarefas com IA' },
                { id: 2, titulo: 'Planejando sua Semana' },
                { id: 3, titulo: 'Técnicas de Foco Assistidas por IA' }
            ],
            materiais: [
                { id: 1, nome: 'Template de Organização Semanal', url: '#' }
            ]
        }
        // Você pode adicionar os dados para os módulos 4, 5, 6, etc., aqui.
    };

    // ========================================================================
    // PASSO 2: LER O ID DO MÓDULO DA URL
    // ========================================================================
    const urlParams = new URLSearchParams(window.location.search);
    const moduloId = urlParams.get('id'); // Pega o valor do parâmetro 'id' (ex: "1", "2", etc.)

    // ========================================================================
    // PASSO 3: SELECIONAR OS DADOS CORRETOS E RENDERIZAR A PÁGINA
    // ========================================================================
    const dadosDoModulo = database[moduloId]; // Usa o ID para buscar os dados no "banco de dados"

    // Referências aos elementos do HTML
    const lessonHeader = document.querySelector('.lesson-header');
    const videoListContainer = document.getElementById('video-list');
    const materialsListContainer = document.getElementById('materials-list');

    function carregarConteudo() {
        // Verifica se o ID é válido e se os dados existem no nosso "banco de dados"
        if (!dadosDoModulo) {
            if (lessonHeader) {
                lessonHeader.innerHTML = `<h1>Módulo não encontrado</h1>`;
            }
            console.error(`Não foram encontrados dados para o módulo com ID: ${moduloId}`);
            return; // Interrompe a execução se o módulo não for encontrado
        }

        // Se encontrou os dados, continua a renderizar a página
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

    // Inicia o carregamento do conteúdo da página
    carregarConteudo();
});
