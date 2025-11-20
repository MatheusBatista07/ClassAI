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
                button.disabled = false;
            } else {
                alert(data.message);
                button.textContent = originalText;
                button.disabled = false;
            }
        }).catch(() => {
            alert('Erro de comunicação.');
            button.textContent = originalText;
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
});
