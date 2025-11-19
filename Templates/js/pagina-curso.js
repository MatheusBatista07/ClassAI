document.addEventListener('DOMContentLoaded', function() {
    const body = document.body;
    const menuButton = document.querySelector(".header_mobile i.bi-list");
    const sidebar = document.querySelector(".sidebar");

    if (menuButton && sidebar) {
        menuButton.addEventListener("click", () => {
            body.classList.toggle("sidebar-open");
        });
    }

    document.addEventListener("click", (e) => {
        if (
            body.classList.contains("sidebar-open") &&
            !sidebar.contains(e.target) &&
            !menuButton.contains(e.target)
        ) {
            body.classList.remove("sidebar-open");
        }
    });

    const btnCancelar = document.getElementById('btn-cancelar-inscricao');

    if (btnCancelar) {
        const modalElement = document.getElementById('modalCancelamento');
        if (!modalElement) {
            console.error('Elemento do modal #modalCancelamento não encontrado.');
            return;
        }
        
        const modal = new bootstrap.Modal(modalElement);
        const btnConfirmar = document.getElementById('btnConfirmarCancelamento');
        const motivoTextarea = document.getElementById('motivoCancelamento');

        btnCancelar.addEventListener('click', function(event) {
            event.preventDefault();
            modal.show();
        });

        btnConfirmar.addEventListener('click', function() {
            const form = document.getElementById('form-cancelar');
            if (!form) {
                console.error('Formulário #form-cancelar não encontrado.');
                return;
            }
            
            const cursoIdInput = form.querySelector('input[name="curso_id"]');
            if (!cursoIdInput) {
                console.error('Input com name="curso_id" não encontrado no formulário.');
                return;
            }

            const cursoId = cursoIdInput.value;
            const motivo = motivoTextarea.value;

            btnConfirmar.disabled = true;
            btnConfirmar.textContent = 'Processando...';

            // AQUI ESTÁ A CORREÇÃO
            fetch('../processaCancelamento.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `curso_id=${cursoId}&motivo=${encodeURIComponent(motivo)}`
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Erro de rede ou servidor: ' + response.statusText);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert(data.message || 'Ocorreu um erro ao processar sua solicitação.');
                        btnConfirmar.disabled = false;
                        btnConfirmar.textContent = 'Sim, cancelar inscrição';
                    }
                })
                .catch(error => {
                    console.error('Erro no fetch:', error);
                    alert('Ocorreu um erro de comunicação. Verifique sua conexão e tente novamente.');
                    btnConfirmar.disabled = false;
                    btnConfirmar.textContent = 'Sim, cancelar inscrição';
                });
        });
    }
});
