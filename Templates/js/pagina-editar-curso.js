document.addEventListener('DOMContentLoaded', function () {

    // --- Funcionalidade: Pré-visualização da Imagem da Capa ---
    const coverUploadInput = document.getElementById('cover-upload');
    const coverImage = document.getElementById('cover-image');

    if (coverUploadInput && coverImage) {
        coverUploadInput.addEventListener('change', function (event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    coverImage.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // --- Funcionalidades da Lista de Profissões ---
    const professionsList = document.getElementById('professions-list');
    const addProfessionBtn = document.getElementById('add-profession-btn');

    if (professionsList) {
        // --- REMOVER PROFISSÃO (Funcionalidade existente) ---
        professionsList.addEventListener('click', function (event) {
            if (event.target.classList.contains('remove-profession')) {
                const itemToRemove = event.target.closest('.profession-item');
                if (itemToRemove) {
                    itemToRemove.remove();
                }
            }
        });
    }

    // --- ADICIONAR PROFISSÃO (Nova Funcionalidade) ---
    if (addProfessionBtn && professionsList) {
        addProfessionBtn.addEventListener('click', function() {
            // Impede a criação de múltiplos inputs vazios
            if (document.querySelector('.new-profession-input-container')) {
                return;
            }

            // 1. Cria os novos elementos HTML
            const container = document.createElement('div');
            container.className = 'new-profession-input-container';

            const input = document.createElement('input');
            input.type = 'text';
            input.placeholder = 'Digite a profissão e pressione Enter';

            // 2. Adiciona o input ao seu contêiner
            container.appendChild(input);

            // 3. Adiciona o novo contêiner à lista na página
            professionsList.appendChild(container);
            input.focus(); // Foca no input automaticamente

            // 4. Adiciona eventos para finalizar a adição
            const finalizeAddition = () => {
                const professionName = input.value.trim(); // Pega o valor e remove espaços extras

                // Se o usuário digitou algo...
                if (professionName) {
                    // Cria o item final (texto + botão 'x')
                    const newItem = document.createElement('div');
                    newItem.className = 'profession-item';
                    newItem.innerHTML = `
                        <span>${professionName}</span>
                        <button type="button" class="remove-profession">&times;</button>
                    `;
                    // Substitui o input pelo item finalizado
                    professionsList.replaceChild(newItem, container);
                } else {
                    // Se não digitou nada, apenas remove o campo de input
                    container.remove();
                }
            };

            // Finaliza a adição quando o usuário pressiona "Enter"
            input.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault(); // Impede o envio do formulário
                    finalizeAddition();
                }
            });

            // Finaliza a adição quando o usuário clica fora do input
            input.addEventListener('blur', finalizeAddition);
        });
    }
});
