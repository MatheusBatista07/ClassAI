// 1. Selecionar os elementos corretamente
// Use querySelector para um único elemento, como o formulário ou o botão.
const form = document.querySelector('.formulario'); 
const entrar = document.querySelector('.entrar');

// Use querySelectorAll para múltiplos elementos, como os inputs ou as mensagens de erro.
const inputs = document.querySelectorAll('input');
const erro = document.querySelectorAll('.msg_erro');

// 2. Renomear a função para corresponder ao que é chamado no evento
function hideErrorMessage() {
    erro.forEach(msg => {
        msg.style.display = 'none';
    });
}

// 3. Adicionar o evento de clique ao botão "Entrar"
entrar.addEventListener("click", (e) => {
    e.preventDefault(); // Impede o envio do formulário

    // Chama a função para esconder as mensagens antes de validar novamente
    hideErrorMessage(); 

    // Itera sobre cada input para validar individualmente
    inputs.forEach(input => {
        if (input.value.trim() === '') {
            // Pega o <p> que vem logo após o <input>
            const errorMessage = input.nextElementSibling;
            
            // Verifica se o elemento encontrado é realmente uma mensagem de erro
            if (errorMessage && errorMessage.classList.contains('msg_erro')) {
                errorMessage.style.display = 'block';
            }
        }
    });
});

// 4. Adicionar os eventos para esconder o erro ao digitar
inputs.forEach(input => {
    input.addEventListener("input", () => {
        const errorMessage = input.nextElementSibling;
        if (errorMessage && errorMessage.classList.contains('msg_erro')) {
            // Esconde a mensagem de erro específica deste input
            errorMessage.style.display = 'none';
        }
    });
});

// 5. Chamar a função uma vez quando a página carrega para garantir que os erros comecem escondidos
hideErrorMessage();
