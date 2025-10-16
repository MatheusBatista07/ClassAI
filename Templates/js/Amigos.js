const API_BASE_AMIGOS = 'Pagina-perfil-amigo.php';

async function loadFriendsList() {
    const friendsList = document.getElementById('friends-list');
    if (!friendsList) {
        console.warn('Elemento #friends-list não encontrado. A função loadFriendsList não será executada.');
        return;
    }

    try {
        console.log('🔄 Carregando amigos...');
        const url = `${API_BASE_AMIGOS}?action=getFriends`;
        const response = await fetch(url);

        if (!response.ok) {
            throw new Error(`Erro HTTP: ${response.status}`);
        }

        const result = await response.json();
        console.log('✅ Resposta Amigos:', result);

        if (result.success && result.data) {
            friendsList.innerHTML = ''; 

            result.data.forEach(friend => {
                const friendElement = document.createElement('div');
                friendElement.className = 'friend-item';

                friendElement.innerHTML = `
                    <img src="../${friend.foto_url}" alt="Foto de ${friend.nome}">
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
            friendsList.innerHTML = `<div class="error">Erro: ${result.error || 'Dados de amigos não encontrados'}</div>`;
        }

    } catch (error) {
        console.error('❌ Erro ao carregar amigos:', error);
        friendsList.innerHTML = `<div class="error">Erro ao carregar a lista de amigos.</div>`;
    }
}

/**
 * @param {HTMLElement} followButton
 */
function toggleFollow(followButton) {
    followButton.classList.toggle('following');
    const friendId = followButton.dataset.friendId;
    const isFollowing = followButton.classList.contains('following');

    if (isFollowing) {
        followButton.textContent = 'Seguindo';
    } else {
        followButton.textContent = 'Seguir';
    }

    console.log(`Amigo ID: ${friendId}, Status Seguindo: ${isFollowing}`);
}

document.addEventListener('DOMContentLoaded', loadFriendsList);
