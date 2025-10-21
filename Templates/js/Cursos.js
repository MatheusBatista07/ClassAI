const API_BASE_CURSOS = 'Pagina-Perfil.php';
async function loadCourses() {
    const coursesList = document.getElementById('courses-list');
    if (!coursesList) {
        console.warn('Elemento #courses-list não encontrado. A função loadCourses não será executada.');
        return;
    }

    try {
        console.log('🔄 Carregando cursos...');
        const url = `${API_BASE_CURSOS}?action=getCourses`;
        const response = await fetch(url);

        if (!response.ok) {
            throw new Error(`Erro HTTP: ${response.status}`);
        }

        const result = await response.json();
        console.log('✅ Resposta Cursos:', result);

        if (result.success && result.data) {
            coursesList.innerHTML = '';

            result.data.forEach(course => {
                const courseElement = document.createElement('div');
                courseElement.className = 'course-card';

                courseElement.innerHTML = `
                    <div class="course-image-container">
                        <img src="../${course.curso_foto_url}" alt="Capa do curso ${course.nome_curso}" class="course-image">
                    </div>
                    <div class="course-info">
                        <div class="course-title-wrapper">
                            <h3 class="course-title">${course.nome_curso}</h3>
                            <i class="far fa-heart" onclick="toggleFavorite(this)" data-course-id="${course.id}"></i>
                        </div>
                        <div class="course-author">
                            <img src="../${course.instrutor_foto_url}" alt="Foto do instrutor ${course.instrutor}">
                            <span>${course.instrutor}</span>
                        </div>
                    </div>
                    <button class="btn-course">${course.status}</button>
                `;
                coursesList.appendChild(courseElement);
            });

            console.log('🎉 Cursos carregados com sucesso!');
        } else {
            coursesList.innerHTML = `<div class="error">Erro: ${result.error || 'Dados de cursos não encontrados'}</div>`;
        }

    } catch (error) {
        console.error('❌ Erro ao carregar cursos:', error);
        coursesList.innerHTML = `<div class="error">Erro ao carregar a lista de cursos.</div>`;
    }
}

/**
 * @param {HTMLElement} heartIcon
 */
function toggleFavorite(heartIcon) {
    heartIcon.classList.toggle('active');
    const courseId = heartIcon.dataset.courseId;
    const isFavorited = heartIcon.classList.contains('active');

    console.log(`Curso ID: ${courseId}, Status Favorito: ${isFavorited}`);
}
document.addEventListener('DOMContentLoaded', loadCourses);