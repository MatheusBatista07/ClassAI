document.addEventListener('DOMContentLoaded', function() {

       const modulosDoCurso = [
        {
            titulo: 'FUNDAMENTOS',
            descricao: 'Fundamentos do ChatGPT Aplicados ao Dia a Dia',
            duracao: '30m',
            imagem: 'https://i.imgur.com/QZ5Am3C.png' // URL da imagem do módulo 1
        },
        {
            titulo: 'AUTOMAÇÃO E CRIATIVIDADE',
            descricao: 'Automatizando Tarefas com Texto e Criatividade',
            duracao: '2h',
            imagem: 'https://i.imgur.com/QZ5Am3C.png' // URL da imagem do módulo 2
        },
        {
            titulo: 'ORGANIZAÇÃO',
            descricao: 'Organização e Produtividade Pessoal com IA',
            duracao: '3h',
            imagem: 'https://i.imgur.com/QZ5Am3C.png' // URL da imagem do módulo 3
        }
    ];

    // 2. Referências aos elementos do HTML
    const track = document.querySelector('.modules-track' );
    const ctaButton = document.querySelector('.cta-button');
    let isSubscribed = false; // Variável para controlar o estado de inscrição

    // 3. Função para renderizar (desenhar) os módulos na tela
    function carregarModulos() {
        if (!track) return; // Se o container não existir, para a função

        track.innerHTML = ''; // Limpa o conteúdo atual para evitar duplicatas

        modulosDoCurso.forEach(modulo => {
            // Cria o HTML para cada card de módulo
            const cardHTML = `
                <div class="module-card">
                    <div class="module-image-container">
                        <img src="${modulo.imagem}" alt="Imagem do módulo ${modulo.titulo}">
                    </div>
                    <div class="module-content">
                        <h3>${modulo.titulo}</h3>
                        <p>${modulo.descricao}</p>
                        <div class="duration">
                            <i class="fas fa-clock"></i>
                            <span>Duração estimada: ${modulo.duracao}</span>
                        </div>
                    </div>
                </div>
            `;
            // Insere o card no container
            track.insertAdjacentHTML('beforeend', cardHTML);
        });

        // Após criar os cards, aplica o estado de bloqueio se necessário
        atualizarEstadoBloqueio();
    }

    // 4. Função para aplicar ou remover o estado de bloqueio
    function atualizarEstadoBloqueio() {
        const allModules = document.querySelectorAll('.module-card');
        
        allModules.forEach(card => {
            // Remove qualquer overlay de bloqueio existente para não acumular
            const existingOverlay = card.querySelector('.lock-overlay');
            if (existingOverlay) {
                existingOverlay.remove();
            }

            // Se o usuário NÃO estiver inscrito, adiciona o overlay de bloqueio
            if (!isSubscribed) {
                card.classList.add('locked'); // Adiciona a classe para CSS
                const lockOverlayHTML = `
                    <div class="lock-overlay">
                        <i class="fas fa-lock lock-icon"></i>
                        <span class="lock-text">Inscreva-se para desbloquear</span>
                    </div>
                `;
                card.insertAdjacentHTML('beforeend', lockOverlayHTML);
            } else {
                // Se o usuário ESTIVER inscrito, remove a classe de bloqueio
                card.classList.remove('locked');
            }
        });
    }

    // 5. Lógica do botão de inscrição
if (ctaButton) {
    ctaButton.addEventListener('click', function(event) {
        // Se já estiver inscrito (e agora for um link), o clique deve seguir o href.
        // Se ainda for um botão, prevenimos o comportamento padrão para executar nossa lógica.
        if (this.tagName === 'BUTTON') {
            event.preventDefault(); 
        } else {
            return; // Se já é um link, deixa o navegador seguir o href.
        }

        // Muda o estado para inscrito
        isSubscribed = true;

        // --- INÍCIO DA MUDANÇA: Transformando o botão em um link ---

        // 1. Cria um novo elemento <a> com as mesmas classes do botão
        const linkButton = document.createElement('a');
        linkButton.className = 'cta-button subscribed'; // Adiciona as classes originais e a nova
        
        // 2. Define o link de destino. Deixei vazio como pediu, mas você pode mudar para a página do curso.
        linkButton.href = "pagina-modulos.php"; // <<<<<<<<<<<<<<< COLOQUE O LINK DE DESTINO AQUI
        
        // 3. Define o conteúdo do novo link (ícone e texto)
        linkButton.innerHTML = 'Acessar Curso'; // Texto mais claro para o usuário

        // 4. Substitui o <button> antigo pelo novo <a> no HTML
        ctaButton.parentNode.replaceChild(linkButton, ctaButton);

        // --- FIM DA MUDANÇA ---

        // Chama a função para remover o bloqueio dos módulos, como antes
        atualizarEstadoBloqueio();
    });
}


    // 6. Carrega os módulos assim que a página é aberta
    carregarModulos();

    });


 