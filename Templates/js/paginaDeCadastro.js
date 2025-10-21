document.addEventListener("DOMContentLoaded", function() {
    // pega o botão de CADASTRAR (não o de entrar)
    const btnCadastrar = document.querySelector("#btnCadastrar");

    if (!btnCadastrar) return; // se não achar, nem faz nada

    btnCadastrar.addEventListener("click", function(event) {
        event.preventDefault(); // trava envio automático

        const email = document.querySelector(".userEmail");
        const senha = document.querySelector(".userPassword");
        const confirma = document.querySelector(".userPasswordConfirm");
        const termos = document.getElementById("termosCheck");

        const emailErro = document.querySelector(".email-erro");
        const senhaErro = document.querySelector(".senha-erro");
        const confirmaErro = document.querySelector(".confirma-erro");
        const termosErro = document.querySelector(".termos-erro");

        let valido = true;

        // Limpa mensagens antigas
        [emailErro, senhaErro, confirmaErro, termosErro].forEach(el => {
            if (el) el.style.display = "none";
        });

        // Valida e-mail
        if (email.value.trim() === "") {
            emailErro.style.display = "block";
            valido = false;
        }

        // Valida senha
        if (senha.value.trim() === "") {
            senhaErro.style.display = "block";
            valido = false;
        }

        // Valida confirmação de senha
        if (confirma.value.trim() === "" || confirma.value !== senha.value) {
            confirmaErro.textContent = confirma.value.trim() === "" 
                ? "Confirme sua senha" 
                : "As senhas não conferem";
            confirmaErro.style.display = "block";
            valido = false;
        }

        // Valida termos
        if (!termos.checked) {
            termosErro.style.display = "block";
            valido = false;
        }

        // Se tudo estiver certo
        if (valido) {
            console.log("Cadastro validado com sucesso!");
            // document.querySelector("form").submit(); // ativa quando quiser enviar o form de verdade
        }
    });
});
