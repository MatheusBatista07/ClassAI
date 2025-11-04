// No arquivo: pagina-curso.js (ou como você o chamou)

document.addEventListener('DOMContentLoaded', function() {
    // ================== CORREÇÃO 1: Simular o ID do curso atual ==================
    // Em um cenário real, o seu PHP/Controller injetaria o ID do curso aqui.
    // Para simular, vamos fingir que estamos na página do curso de ID 7.
    const CURSO_ID_ATUAL = 7;

    const modulosDoCurso = [
        { id: 1, titulo: 'FUNDAMENTOS', /*...*/ },
        { id: 2, titulo: 'AUTOMAÇÃO E CRIATIVIDADE', /*...*/ },
        { id: 3, titulo: 'ORGANIZAÇÃO', /*...*/ }
    ];

    const track = document.querySelector('.modules-track');
    const ctaButton = document.querySelector('.cta-button');
    let isSubscribed = false;

    function carregarModulos() {
        if (!track) return;
        track.innerHTML = '';
        modulosDoCurso.forEach(modulo => {
            // ================== CORREÇÃO 2: Remover o link daqui ==================
            // Esta página não deve ter links para as aulas. Os módulos são apenas visuais.
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
            track.insertAdjacentHTML('beforeend', cardHTML);
        });
        atualizarEstadoBloqueio();
    }

    function atualizarEstadoBloqueio() {
        const allModules = document.querySelectorAll('.module-card');
        allModules.forEach(card => {
            const existingOverlay = card.querySelector('.lock-overlay');
            if (existingOverlay) existingOverlay.remove();

            if (!isSubscribed) {
                const lockOverlayHTML = `...`; // Sua lógica de overlay está OK
                card.insertAdjacentHTML('beforeend', lockOverlayHTML);
            }
        });
    }

    if (ctaButton) {
        ctaButton.addEventListener('click', function(event) {
            if (this.tagName === 'BUTTON') event.preventDefault();
            else return;

            isSubscribed = true;
            const linkButton = document.createElement('a');
            linkButton.className = 'cta-button subscribed';

            // ================== CORREÇÃO 3: Passar o ID do curso para a próxima página ==================
            linkButton.href = `meu-curso.php?curso_id=${CURSO_ID_ATUAL}`;
            
            linkButton.innerHTML = 'Acessar Curso';
            ctaButton.parentNode.replaceChild(linkButton, ctaButton);
            atualizarEstadoBloqueio();
        });
    }

    carregarModulos();


const body = document.body;
  const menuButton = document.querySelector(".header_mobile i.bi-list"); // Ícone do menu hambúrguer
  const sidebar = document.querySelector(".sidebar");

  if (menuButton && sidebar) {
    menuButton.addEventListener("click", () => {
      // Alterna a classe que abre ou fecha a sidebar
      body.classList.toggle("sidebar-open");
    });
  }

  // Fecha a sidebar ao clicar fora dela (opcional)
  document.addEventListener("click", (e) => {
    if (
      body.classList.contains("sidebar-open") &&
      !sidebar.contains(e.target) &&
      !menuButton.contains(e.target)
    ) {
      body.classList.remove("sidebar-open");
    }
  });
});
