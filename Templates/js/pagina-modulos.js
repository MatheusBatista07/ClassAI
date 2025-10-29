// No arquivo: meu-curso.js

document.addEventListener('DOMContentLoaded', function() {
    // ================== CORREÇÃO 1: Adotar a mesma lógica da página de aulas ==================
    
    // Simular um banco de dados de módulos, organizados por curso_id
    const databaseModulos = {
        '7': [ // Módulos para o curso_id = 7
            { id: 1, descricao: 'Fundamentos do ChatGPT e Aplicações no Dia a Dia', imagem: '...', duracao: '1h30' },
            { id: 2, descricao: 'Automatizando Tarefas com Texto e Criatividade', imagem: '...', duracao: '2h' },
            { id: 3, descricao: 'Organização Pessoal e Produtividade com a IA', imagem: '...', duracao: '2h' }
        ],
        '8': [ // Módulos para um hipotético curso_id = 8 (Python)
            { id: 4, descricao: 'Sintaxe Básica do Python', imagem: '...', duracao: '1h' },
            { id: 5, descricao: 'Estruturas de Dados', imagem: '...', duracao: '2h' }
        ]
    };

    // Ler qual curso deve ser exibido
    const urlParams = new URLSearchParams(window.location.search);
    const cursoId = urlParams.get('curso_id');

    // Selecionar os módulos corretos com base no ID do curso
    const modulosDoCurso = databaseModulos[cursoId] || []; // Pega os módulos ou um array vazio se o curso não for encontrado

    const gridContainer = document.getElementById('modules-grid');

    function carregarModulos() {
        if (!gridContainer) return;
        gridContainer.innerHTML = '';

        if (modulosDoCurso.length === 0) {
            gridContainer.innerHTML = '<p>Nenhum módulo encontrado para este curso.</p>';
            return;
        }

        modulosDoCurso.forEach(modulo => {
            // ================== CORREÇÃO 2: Usar o nome de parâmetro consistente ('id') ==================
            const cardHTML = `
                <a href="pagina-aula.php?id=${modulo.id}" class="module-card">
                    <div class="module-image-container">
                        <img src="${modulo.imagem}" alt="Capa do módulo">
                    </div>
                    <div class="module-content">
                        <h3>Módulo ${modulo.id} <i class="far fa-bookmark"></i></h3>
                        <p>${modulo.descricao}</p>
                        <div class="duration">
                            <i class="far fa-clock"></i>
                            <span>Duração estimada: ${modulo.duracao}</span>
                        </div>
                    </div>
                </a>
            `;
            gridContainer.insertAdjacentHTML('beforeend', cardHTML);
        });
    }

    carregarModulos();
});
