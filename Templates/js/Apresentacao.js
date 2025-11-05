const form = document.querySelector('form')
const inputs = document.querySelectorAll('input')
const button = document.getElementById('envio')

form.addEventListener('submit', (event) => {
    event.preventDefault()
})

button.addEventListener("click", () => {
    function submit() {
        form.submit()
    }

    const allFilled = Array.from(inputs).every(input => input.value.trim() !== '')

    if (allFilled) {
        submit()
    } else {
        alert("Erro ao enviar a mensagem")
    }

    button.addEventListener("keypress", function (event) {
        // If the user presses the "Enter" key on the keyboard
        if (event.key === "Enter") {
            // Cancel the default action, if needed
            event.preventDefault();
            // Trigger the button element with a click
            document.getElementById("button").click();
        }
    });
})