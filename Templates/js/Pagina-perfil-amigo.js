const API_BASE = 'Pagina-perfil-amigo.php';

async function loadFriendsList() {
    try {
        console.log('🔄 Carregando amigos...');
        const url = `${API_BASE}?action=getFriends`;
        console.log('📡 URL:', url);
        const response = await fetch(url);

        if (!response.ok) {
            throw new Error(`Erro HTTP: ${response.status}`);
        }

        const result = await response.json();
        console.log('✅ Resposta Amigos:', result);
        const friendsList = document.getElementById('friends-list');

        if (result.success && result.data) {
            friendsList.innerHTML = '';

            result.data.forEach(friend => {
                const friendElement = document.createElement('div');
                friendElement.className = 'friend-item';

                friendElement.innerHTML = `
                    <img src="../${friend.foto_url}" alt="${friend.nome}">
                    <div class="friend-details">
                        <p class="friend-name">${friend.nome}</p>
                        <p class="friend-role">${friend.cargo}</p>
                    </div>
                    <button class="friend-action" onclick="toggleFollow(this)" data-friend-id="${friend.id}">Seguir</button>

                `;
                friendsList.appendChild(friendElement);
            });

            console.log('🎉 Amigos carregados com sucesso!');
        } else {
            friendsList.innerHTML = '<div class="error">Erro: ' + (result.error || 'Dados não encontrados') + '</div>';
        }

    } catch (error) {
        console.error('❌ Erro ao carregar amigos:', error);
        document.getElementById('friends-list').innerHTML = '<div class="error">Erro ao carregar amigos: ' + error.message + '</div>';
    }
}

async function loadCourses() {
    try {
        console.log('🔄 Carregando cursos...');
        const url = `${API_BASE}?action=getCourses`;
        console.log('📡 URL:', url);
        const response = await fetch(url);

        if (!response.ok) {
            throw new Error(`Erro HTTP: ${response.status}`);
        }

        const result = await response.json();
        console.log('✅ Resposta Cursos:', result);
        const coursesList = document.getElementById('courses-list');

        if (result.success && result.data) {
            coursesList.innerHTML = '';

            result.data.forEach(course => {

                const courseElement = document.createElement('div');
                courseElement.className = 'course-card';

                courseElement.innerHTML = `
    <div class="course-image-container">
        <img src="../${course.curso_foto_url}" alt="${course.nome_curso}" class="course-image">
    </div>
    <div class="course-info">
        <div class="course-title-wrapper">
            <h3 class="course-title">${course.nome_curso}</h3>
           <i class="far fa-heart" onclick="toggleFavorite(this)" data-course-id="${course.id}"></i>

        </div>
        <div class="course-author">
            <img src="../${course.instrutor_foto_url}" alt="${course.instrutor}">
            <span>${course.instrutor}</span>
        </div>
    </div>
    <button class="btn-course">${course.status}</button>
`;
                coursesList.appendChild(courseElement);
            });

            console.log('🎉 Cursos carregados com sucesso!');
        } else {
            coursesList.innerHTML = '<div class="error">Erro: ' + (result.error || 'Dados não encontrados') + '</div>';
        }

    } catch (error) {
        console.error('❌ Erro ao carregar cursos:', error);
        document.getElementById('courses-list').innerHTML = '<div class="error">Erro ao carregar cursos: ' + error.message + '</div>';
    }
}

// ... seu código existente (loadFriendsList, loadCourses) ...

// NOVA FUNÇÃO PARA FAVORITAR CURSOS
function toggleFavorite(heartIcon) {
    heartIcon.classList.toggle('active');
    const courseId = heartIcon.dataset.courseId;
    const isFavorited = heartIcon.classList.contains('active');
    console.log(`Curso ID: ${courseId}, Status Favorito: ${isFavorited}`);
}

// NOVA FUNÇÃO PARA SEGUIR/DEIXAR DE SEGUIR AMIGOS
function toggleFollow(followButton) {
    followButton.classList.toggle('following');
    if (followButton.classList.contains('following')) {
        followButton.textContent = 'Seguindo';
    } else {
        followButton.textContent = 'Seguir';
    }
    const friendId = followButton.dataset.friendId;
    const isFollowing = followButton.classList.contains('following');
    console.log(`Amigo ID: ${friendId}, Status Seguindo: ${isFollowing}`);
}

document.addEventListener('DOMContentLoaded', function () {
    console.log('🚀 ClassAI - Página carregada');
    loadFriendsList();
    loadCourses();
});