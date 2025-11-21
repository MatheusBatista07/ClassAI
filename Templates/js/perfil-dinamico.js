document.addEventListener('DOMContentLoaded', function() {
    const btnVoltar = document.getElementById('btn-voltar-perfil');
    if (btnVoltar) {
        btnVoltar.addEventListener('click', function(event) {
            event.preventDefault();
            window.history.back();
        });
    }

    const form = document.getElementById('form-editar-perfil');
    if (!form) return;

    function handleConexao(event) {
        const button = event.target.closest('.btn-amigos');
        if (!button) return;

        const userId = button.dataset.userid;
        let acao = button.classList.contains('btn-follow') ? 'seguir' : 'deixar_de_seguir';

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
                    button.textContent = 'Deixar de Seguir';
                    button.classList.remove('btn-follow');
                    button.classList.add('btn-unfollow');
                } else {
                    button.textContent = 'Seguir';
                    button.classList.remove('btn-unfollow');
                    button.classList.add('btn-follow');
                }
                
                const followerCountSpan = document.getElementById('follower-count');
                if (followerCountSpan && data.novaContagemSeguidores !== undefined) {
                    followerCountSpan.textContent = data.novaContagemSeguidores;
                }

            } else {
                alert(data.message);
                button.textContent = originalText;
            }
        }).catch(() => {
            alert('Erro de comunicação.');
            button.textContent = originalText;
        }).finally(() => {
            button.disabled = false;
        });
    }

    form.addEventListener('click', handleConexao);

    const btnEditar = document.getElementById('btn-editar');
    if (btnEditar) {
        const btnSalvar = document.getElementById('btn-salvar');
        const btnCancelar = document.getElementById('btn-cancelar');
        const feedbackDiv = document.getElementById('form-feedback');
        const viewElements = document.querySelectorAll('.view-mode');
        const editElements = document.querySelectorAll('.edit-mode');

        function toggleEditMode(isEditing) {
            viewElements.forEach(el => el.style.display = isEditing ? 'none' : '');
            editElements.forEach(el => el.style.display = isEditing ? '' : 'none');
        }

        btnEditar.addEventListener('click', () => toggleEditMode(true));
        btnCancelar.addEventListener('click', () => {
            toggleEditMode(false);
            feedbackDiv.style.display = 'none';
        });

        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const editData = new FormData(form);
            btnSalvar.disabled = true;
            btnSalvar.textContent = 'Salvando...';

            fetch('/ClassAI/Controller/processar-edicao-perfil.php', {
                method: 'POST',
                body: editData
            })
            .then(response => response.json())
            .then(data => {
                feedbackDiv.textContent = data.message;
                feedbackDiv.className = `alert ${data.status === 'success' ? 'alert-success' : 'alert-danger'}`;
                feedbackDiv.style.display = 'block';

                if (data.status === 'success') {
                    document.querySelector('.view-mode').textContent = data.novoNomeCompleto;
                    const headerUserName = document.querySelector('.popup-user-name');
                    if(headerUserName) headerUserName.textContent = data.novoNomeCompleto;
                    setTimeout(() => {
                        toggleEditMode(false);
                        feedbackDiv.style.display = 'none';
                    }, 2000);
                }
            })
            .catch(error => {
                feedbackDiv.textContent = 'Erro de comunicação.';
                feedbackDiv.className = 'alert alert-danger';
                feedbackDiv.style.display = 'block';
            })
            .finally(() => {
                btnSalvar.disabled = false;
                btnSalvar.textContent = 'Salvar Alterações';
            });
        });
    }

    const modal = document.getElementById('follow-modal');
    const modalTitle = document.getElementById('modal-title');
    const modalBody = document.getElementById('modal-body');
    const closeModalBtn = document.getElementById('modal-close-btn');
    const followersLink = document.getElementById('followers-link');
    const followingLink = document.getElementById('following-link');
    const perfilId = document.getElementById('form-editar-perfil').dataset.perfilId;

    async function openModal(type) {
        modalTitle.textContent = type === 'followers' ? 'Seguidores' : 'Seguindo';
        modalBody.innerHTML = '<p class="modal-loading">Carregando...</p>';
        modal.style.display = 'flex';
        setTimeout(() => modal.classList.add('show'), 10);

        try {
            const response = await fetch(`/ClassAI/api.php?action=getFollowList&userId=${perfilId}&type=${type}`);
            const data = await response.json();

            if (data.status === 'success' && data.list) {
                modalBody.innerHTML = '';
                if (data.list.length === 0) {
                    modalBody.innerHTML = `<p class="modal-loading">Nenhum usuário encontrado.</p>`;
                } else {
                    data.list.forEach(user => {
                        const userElement = document.createElement('a');
                        userElement.href = `pagina-perfil.php?id=${user.id}`;
                        userElement.className = 'modal-user-item';
                        userElement.innerHTML = `
                            <img src="${user.foto_perfil_url}" alt="Foto de ${user.nome}">
                            <span>${user.nome} ${user.sobrenome}</span>
                        `;
                        modalBody.appendChild(userElement);
                    });
                }
            } else {
                modalBody.innerHTML = `<p class="modal-loading">Erro ao carregar a lista.</p>`;
            }
        } catch (error) {
            console.error('Erro ao buscar lista:', error);
            modalBody.innerHTML = `<p class="modal-loading">Erro de comunicação.</p>`;
        }
    }

    function closeModal() {
        modal.classList.remove('show');
        setTimeout(() => modal.style.display = 'none', 300);
    }

    if (followersLink) followersLink.addEventListener('click', () => openModal('followers'));
    if (followingLink) followingLink.addEventListener('click', () => openModal('following'));
    if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
    if (modal) modal.addEventListener('click', (event) => {
        if (event.target === modal) closeModal();
    });
});
