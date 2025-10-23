document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector(".formulario");

    if (!form) return;

    form.addEventListener("submit", function (event) {
        
        const senha = document.querySelector(".userPassword");
        const confirma = document.querySelector(".userPasswordConfirm");

        
        if (senha.value !== confirma.value) {
            
            event.preventDefault(); 
            
            alert("As senhas não conferem. Por favor, verifique.");

            senha.value = "";
            confirma.value = "";
            senha.focus();
        }
        
    });
});
