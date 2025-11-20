document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('form-editar-perfil');
    const btnEditar = document.getElementById('btn-editar');
    const btnSalvar = document.getElementById('btn-salvar');
    const btnCancelar = document.getElementById('btn-cancelar');
    const feedbackDiv = document.getElementById('form-feedback');

    const viewElements = document.querySelectorAll('.view-mode');
    const editElements = document.querySelectorAll('.edit-mode');

    function toggleEditMode(isEditing) {
        viewElements.forEach(el => el.style.display = isEditing ? 'none' : '');
        editElements.forEach(el => el.style.display = isEditing ? '' : 'none');
    }

    btnEditar.addEventListener('click', () => {
        toggleEditMode(true);
    });

    btnCancelar.addEventListener('click', () => {
        toggleEditMode(false);
        feedbackDiv.style.display = 'none';
    });

    form.addEventListener('submit', function(event) {
        event.preventDefault();

        const formData = new FormData(form);
        btnSalvar.disabled = true;
        btnSalvar.textContent = 'Salvando...';

        fetch('/ClassAI/Controller/processar-edicao-perfil.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            feedbackDiv.textContent = data.message;
            feedbackDiv.className = `alert ${data.status === 'success' ? 'alert-success' : 'alert-danger'}`;
            feedbackDiv.style.display = 'block';

            if (data.status === 'success') {
                const nomeCompletoSpan = document.querySelector('.view-mode');
                nomeCompletoSpan.textContent = data.novoNomeCompleto;
                
                const headerUserName = document.querySelector('.popup-user-name');
                if(headerUserName) {
                    headerUserName.textContent = data.novoNomeCompleto;
                }

                setTimeout(() => {
                    toggleEditMode(false);
                    feedbackDiv.style.display = 'none';
                }, 2000);
            }
        })
        .catch(error => {
            feedbackDiv.textContent = 'Ocorreu um erro de comunicação. Tente novamente.';
            feedbackDiv.className = 'alert alert-danger';
            feedbackDiv.style.display = 'block';
            console.error('Erro:', error);
        })
        .finally(() => {
            btnSalvar.disabled = false;
            btnSalvar.textContent = 'Salvar Alterações';
        });
    });
});
