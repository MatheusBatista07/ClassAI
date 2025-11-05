document.addEventListener('DOMContentLoaded', function() {

    // --- LÓGICA PARA CURTIR CURSOS ---
    const courseCards = document.querySelectorAll('.course-card');

    courseCards.forEach(card => {
        card.addEventListener('click', function(event) {
            // Pega o pseudo-elemento ::after que é o nosso coração
            const heart = window.getComputedStyle(card, '::after');
            
            // Calcula a área clicável do coração (canto superior direito)
            const heartSize = 32; // O tamanho que definimos no CSS
            const cardRect = card.getBoundingClientRect();
            const heartX = cardRect.right - (parseFloat(heart.right) + heartSize / 2);
            const heartY = cardRect.top + (parseFloat(heart.top) + heartSize / 2);

            // Calcula a distância do clique ao centro do coração
            const distance = Math.sqrt(Math.pow(event.clientX - heartX, 2) + Math.pow(event.clientY - heartY, 2));

            // Se o clique foi dentro do raio do coração
            if (distance < heartSize / 2) {
                event.preventDefault(); // Impede outras ações (como seguir um link do card)
                event.stopPropagation(); // Para a propagação do evento

                // Alterna a classe 'liked' para mudar o visual do coração
                card.classList.toggle('liked');

                // Pega o ID do curso
                const courseId = card.dataset.courseId;
                const isLiked = card.classList.contains('liked');

                // Envia a informação para o backend
                toggleLike(courseId, isLiked);
            }
        });
    });

    /**
     * Envia a requisição para o backend para curtir ou descurtir um curso.
     * @param {string} courseId - O ID do curso.
     * @param {boolean} isLiked - True se o curso foi curtido, false se foi descurtido.
     */
    function toggleLike(courseId, isLiked) {
        console.log(`Enviando: Curso ID ${courseId}, Ação: ${isLiked ? 'Curtir' : 'Descurtir'}`);

        // A URL deve apontar para o seu método no controller
        // Exemplo: 'index.php?action=toggle-like' ou '/curso/curtir'
        const endpoint = '/user/toggle-like'; // <-- IMPORTANTE: AJUSTE ESTA ROTA

        fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest' // Padrão para identificar requisições AJAX
            },
            body: JSON.stringify({
                course_id: courseId,
                liked: isLiked
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Falha na resposta do servidor.');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                console.log('Servidor respondeu:', data.message);
            } else {
                console.error('O servidor indicou uma falha:', data.message);
                // Se falhou, desfaz a mudança visual para o usuário
                const card = document.querySelector(`.course-card[data-course-id='${courseId}']`);
                if (card) {
                    card.classList.toggle('liked');
                }
            }
        })
        .catch(error => {
            console.error('Erro na requisição fetch:', error);
            // Desfaz a mudança visual em caso de erro de rede
            const card = document.querySelector(`.course-card[data-course-id='${courseId}']`);
            if (card) {
                card.classList.toggle('liked');
            }
        });
    }

    // --- LÓGICA PARA O MENU HAMBÚRGUER (BÔNUS) ---
    const menuToggle = document.querySelector('.header_mobile i');
    const sidebar = document.querySelector('.sidebar');
    const body = document.body;

    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', () => {
            body.classList.toggle('sidebar-open');
        });
    }
});
