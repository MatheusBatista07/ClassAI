document.addEventListener('DOMContentLoaded', function () {

    const setupPasswordToggle = (toggleId, passwordId) => {
        const toggleElement = document.getElementById(toggleId);
        const passwordElement = document.getElementById(passwordId);

        if (toggleElement && passwordElement) {
            toggleElement.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                
                const isPassword = passwordElement.getAttribute('type') === 'password';
                passwordElement.setAttribute('type', isPassword ? 'text' : 'password');
                
                this.classList.toggle('bi-eye-slash');
                this.classList.toggle('bi-eye');
            });
        }
    };

    setupPasswordToggle('togglePassword', 'userPassword');
    setupPasswordToggle('togglePasswordConfirm', 'userPasswordConfirm');

});
