document.addEventListener('DOMContentLoaded', function() {

    // 1. Simulação dos dados dos módulos (mesmos dados da página anterior)
    const modulosDoCurso = [
        {
            modulo: 1,
            titulo: 'FUNDAMENTOS',
            descricao: 'Fundamentos do ChatGPT e Aplicações no Dia a Dia',
            duracao: '1h30',
            imagem: 'https://i.imgur.com/QZ5Am3C.png'
        },
        {
            modulo: 2,
            titulo: 'AUTOMAÇÃO E CRIATIVIDADE',
            descricao: 'Automatizando Tarefas com Texto e Criatividade',
            duracao: '2h',
            imagem: 'https://i.imgur.com/uVw02Tf.png' // Imagem diferente para o módulo 2
        },
        {
            modulo: 3,
            titulo: 'ORGANIZAÇÃO E PRODUTIVIDADE',
            descricao: 'Organização Pessoal e Produtividade com a IA',
            duracao: '2h',
            imagem: 'https://i.imgur.com/7gKk9dC.png' // Imagem diferente para o módulo 3
        },
        // Adicione mais módulos aqui para testar o grid
        {
            modulo: 4,
            titulo: 'FUNDAMENTOS',
            descricao: 'Fundamentos do ChatGPT e Aplicações no Dia a Dia',
            duracao: '1h30',
            imagem: 'https://i.imgur.com/QZ5Am3C.png'
        },
        {
            modulo: 5,
            titulo: 'AUTOMAÇÃO E CRIATIVIDADE',
            descricao: 'Automatizando Tarefas com Texto e Criatividade',
            duracao: '2h',
            imagem: 'https://i.imgur.com/uVw02Tf.png'
        },
        {
            modulo: 6,
            titulo: 'ORGANIZAÇÃO E PRODUTIVIDADE',
            descricao: 'Organização Pessoal e Produtividade com a IA',
            duracao: '2h',
            imagem: 'https://i.imgur.com/7gKk9dC.png'
        },
    ];

    // 2. Referência ao container do grid no HTML
    const gridContainer = document.getElementById('modules-grid' );

    // 3. Função para renderizar os módulos
    function carregarModulos() {
        if (!gridContainer) return;

        gridContainer.innerHTML = ''; // Limpa o container

        modulosDoCurso.forEach(modulo => {
            // Cria o HTML para cada card. Note que o card inteiro é um link.
            const cardHTML = `
                <a href="/curso/modulo/${modulo.modulo}" class="module-card">
                    <div class="module-image-container">
                        <img src="${modulo.imagem}" alt="Capa do ${modulo.titulo}">
                    </div>
                    <div class="module-content">
                        <h3>Módulo ${modulo.modulo} <img src="../Images/Página do Curso/ícone de livro.png"></img></h3>
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

    // 4. Carrega os módulos quando a página é aberta
    carregarModulos();

});
