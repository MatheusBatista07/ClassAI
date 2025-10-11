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
                // CORREÇÃO 1: A classe principal do card de amigo é 'friend-item'
                friendElement.className = 'friend-item';

                // CORREÇÃO 2: A estrutura interna do HTML foi ajustada para corresponder ao CSS.
                // Usamos 'friend-details' para agrupar nome e cargo.
                friendElement.innerHTML = `
                    <img src="../${friend.foto_url}" alt="${friend.nome}">
                    <div class="friend-details">
                        <p class="friend-name">${friend.nome}</p>
                        <p class="friend-role">${friend.cargo}</p>
                    </div>
                    <button class="friend-action" onclick="addFriend(${friend.id})">Seguir</button>
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
        <!-- NOVO CONTAINER PARA TÍTULO + CORAÇÃO -->
        <div class="course-title-wrapper">
            <h3 class="course-title">${course.nome_curso}</h3>
            <i class="far fa-heart"></i>  <!-- CORAÇÃO MOVIDO PARA CÁ -->
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

function addFriend(friendId) {
    // Ação de seguir amigo (ex: chamada à API)
    console.log('Seguindo amigo ID: ' + friendId);
    alert('Função addFriend chamada para o ID: ' + friendId);
}

// Inicializar
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 ClassAI - Página carregada');
    loadFriendsList();
    loadCourses();
});