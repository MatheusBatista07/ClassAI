document.addEventListener('DOMContentLoaded', function() {
    
    const emailInput = document.querySelector('.userEmail');
    const senhaInput = document.querySelector('.userPassword');
    const erroBox = document.querySelector('.error-box-php');

    if (erroBox) {
        
        const esconderErro = function() {
            erroBox.style.display = 'none';
        };
        emailInput.addEventListener('input', esconderErro);
        senhaInput.addEventListener('input', esconderErro);
    }
});
