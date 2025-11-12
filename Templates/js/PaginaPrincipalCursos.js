document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search-input');
    const coursesList = document.getElementById('courses-list');
    const allCourses = coursesList.querySelectorAll('.course-card');

    if (searchInput && coursesList) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase().trim();
            allCourses.forEach(card => {
                const title = card.dataset.title || '';
                const prof = card.dataset.prof || '';
                if (title.includes(searchTerm) || prof.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    const body = document.body;
    const menuButton = document.querySelector(".header_mobile i.bi-list");
    const sidebar = document.querySelector(".sidebar");
    if (menuButton && sidebar) {
        menuButton.addEventListener("click", () => {
            body.classList.toggle("sidebar-open");
        });
    }

    if (coursesList) {
        coursesList.addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-enroll')) {
                const card = event.target.closest('.course-card');
                const courseId = card.dataset.courseId;
                handleEnrollment(courseId, 'matricular');
            }
        });
    }
});

async function handleEnrollment(courseId, acao) {
    try {
        const response = await fetch('/ClassAI/Controller/GerenciarInscricaoController.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ curso_id: courseId, acao: acao })
        });

        if (!response.ok) {
            throw new Error(`Falha na resposta do servidor: ${response.status} ${response.statusText}`);
        }

        const result = await response.json();

        if (result.success) {
            window.location.reload();
        } else {
            alert('Erro: ' + (result.message || 'Não foi possível completar a ação.'));
        }
    } catch (error) {
        console.error('Falha na requisição:', error);
        alert('Ocorreu um erro de comunicação com o servidor.');
    }
}
