document.addEventListener('DOMContentLoaded', function() {
    const tabs = document.querySelectorAll('.tab-link');
    const contents = document.querySelectorAll('.tab-content');
    const searchInput = document.getElementById('search-input');
    const searchResultsContainer = document.getElementById('search-results');


    function performSearch() {
        const termo = searchInput.value.trim();
        const currentHash = window.location.hash || '#encontrar';
        if (termo.length > 0) {
            window.history.replaceState(null, '', `${currentHash}?q=${encodeURIComponent(termo)}`);
        } else {
            window.history.replaceState(null, '', currentHash);
        }

        if (termo.length < 2) {
            searchResultsContainer.innerHTML = '<p class="empty-tab-message">Digite pelo menos 2 caracteres para buscar.</p>';
            return;
        }
        searchResultsContainer.innerHTML = '<p class="empty-tab-message">Buscando...</p>';

        fetch(`/ClassAI/Controller/buscar-usuarios.php?termo=${encodeURIComponent(termo)}`)
            .then(response => response.json())
            .then(users => {
                let html = '';
                if (users.length > 0) {
                    users.forEach(user => {
                        const fotoUrl = user.foto_perfil_url ? `/ClassAI/${user.foto_perfil_url}` : 'https://via.placeholder.com/50';
                        html += `
                            <div class="user-item">
                                <a href="pagina-perfil.php?id=${user.id}" class="user-link">
                                    <img src="${fotoUrl}" alt="Foto de ${user.nome}">
                                    <span>${user.nome} ${user.sobrenome}</span>
                                </a>
                                <button class="btn-amigos btn-follow" data-userid="${user.id}">Seguir</button>
                            </div>
                        `;
                    } );
                } else {
                    html = '<p class="empty-tab-message">Nenhum usuário encontrado.</p>';
                }
                searchResultsContainer.innerHTML = html;
            })
            .catch(error => {
                console.error('Erro ao buscar usuários:', error);
                searchResultsContainer.innerHTML = '<p class="empty-tab-message">Ocorreu um erro ao buscar. Tente novamente.</p>';
            });
    }

    function activateTab(tabId) {
        tabs.forEach(t => t.classList.toggle('active', t.dataset.tab === tabId));
        contents.forEach(c => c.classList.toggle('active', c.id === tabId));
    }

    function handleConexao(event) {
        const button = event.target.closest('.btn-amigos');
        if (!button) return;
        const userId = button.dataset.userid;
        let acao = button.classList.contains('btn-follow') ? 'seguir' : 'deixar_de_seguir';
        if (!acao) return;

        const originalText = button.textContent;
        button.disabled = true;
        button.textContent = '...';
        const formData = new FormData();
        formData.append('alvo_id', userId);
        formData.append('acao', acao);

        fetch('/ClassAI/Controller/processar-conexao.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                if (acao === 'seguir') {
                    button.textContent = 'Seguindo';
                    button.classList.remove('btn-follow');
                    button.classList.add('btn-following');
                    button.disabled = true;
                } else if (acao === 'deixar_de_seguir') {
                    button.closest('.user-item').remove();
                }
            } else {
                alert(data.message || 'Ocorreu um erro.');
                button.textContent = originalText;
                button.disabled = false;
            }
        })
        .catch(error => {
            console.error('Erro na requisição:', error);
            alert('Erro de comunicação com o servidor.');
            button.textContent = originalText;
            button.disabled = false;
        });
    }


    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const tabId = tab.dataset.tab;
            activateTab(tabId);
            window.history.pushState(null, '', `#${tabId}`);
        });
    });

    let searchTimeout;
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(performSearch, 300);
    });

    document.querySelector('.amigos-card').addEventListener('click', handleConexao);


    function initializePage() {
        const hash = window.location.hash.substring(1).split('?')[0] || 'seguindo';
        const params = new URLSearchParams(window.location.hash.split('?')[1]);
        const query = params.get('q');

        activateTab(hash);

        if (hash === 'encontrar' && query) {
            searchInput.value = query;
            performSearch();
        }
    }

    window.addEventListener('popstate', initializePage);

    initializePage();
});
