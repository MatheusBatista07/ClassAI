// Aguarda o documento HTML ser completamente carregado
document.addEventListener('DOMContentLoaded', function() {

    // --- LÓGICA PARA O PREVIEW DA IMAGEM ---

    const fotoInput = document.getElementById('foto-perfil');
    const imagePreview = document.getElementById('imagePreview');
    const plusIcon = document.querySelector('.upload-label .bi-plus');

    // Verifica se os elementos existem antes de adicionar listeners
    if (fotoInput && imagePreview && plusIcon) {
        fotoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                    plusIcon.style.display = 'none'; // Esconde o ícone de '+'
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // --- LÓGICA PARA VALIDAÇÃO DO FORMULÁRIO ---

    const form = document.querySelector('.formulario');
    const userNameInput = document.querySelector('.userName');
    const userNameError = document.querySelector('.nome-erro');

    // Verifica se o formulário existe antes de adicionar o listener
    if (form) {
        form.addEventListener('submit', function(event) {
            // Impede o envio padrão para fazer a validação primeiro
            event.preventDefault(); 

            let isFormValid = true;

            // 1. Valida o campo de nome de usuário
            if (userNameInput.value.trim() === '') {
                userNameError.style.display = 'block'; // Mostra a mensagem de erro
                isFormValid = false;
            } else {
                userNameError.style.display = 'none'; // Esconde a mensagem de erro
            }

            // 2. Se o formulário for válido, envia para o PHP
            if (isFormValid) {
                console.log("Formulário de personalização validado. Enviando...");
                form.submit(); // Envia o formulário
            } else {
                console.log("Formulário de personalização inválido.");
            }
        });
    }
});
