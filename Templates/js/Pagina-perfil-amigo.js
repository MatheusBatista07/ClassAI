
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
        console.log('✅ Resposta:', result);
        
        const friendsList = document.getElementById('friends-list');
        
        if (result.success && result.data) {
            friendsList.innerHTML = '';
            
            result.data.forEach(friend => {
                const friendElement = document.createElement('div');
                friendElement.className = 'friend-item';
                friendElement.innerHTML = `
                    <img src="../${friend.foto_url}" alt="${friend.nome}" class="friend-photo">
                    <div class="friend-info">
                        <div class="friend-name">${friend.nome}</div>
                        <div class="friend-role">${friend.cargo}</div>
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
        console.error('❌ Erro:', error);
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
        console.log('✅ Resposta:', result);
        
        const coursesList = document.getElementById('courses-list');
        
        if (result.success && result.data) {
            coursesList.innerHTML = '';
            
            result.data.forEach(course => {
                const courseElement = document.createElement('div');
                courseElement.className = 'course-item';
                courseElement.innerHTML = `
                    <div class="course-header">
                        <img src="../${course.curso_foto_url}" alt="${course.nome_curso}" class="course-photo">
                    </div>
                    <div class="course-content">
                        <div class="course-info">
                            <div class="course-name">${course.nome_curso}</div>
                            <div class="course-instructor">
                                <img src="../${course.instrutor_foto_url}" alt="${course.instrutor}" class="instructor-photo">
                                ${course.instrutor}
                            </div>
                        </div>
                        <div class="course-status">${course.status}</div>
                    </div>
                `;
                coursesList.appendChild(courseElement);
            });
            
            console.log('🎉 Cursos carregados com sucesso!');
        } else {
            coursesList.innerHTML = '<div class="error">Erro: ' + (result.error || 'Dados não encontrados') + '</div>';
        }
        
    } catch (error) {
        console.error('❌ Erro:', error);
        document.getElementById('courses-list').innerHTML = '<div class="error">Erro ao carregar cursos: ' + error.message + '</div>';
    }
}

function addFriend(friendId) {
    alert('Seguindo amigo ID: ' + friendId);
}

// Inicializar
document.addEventListener('DOMContentLoaded', function() {
    console.log('🚀 ClassAI - Página carregada');
    loadFriendsList();
    loadCourses();
});