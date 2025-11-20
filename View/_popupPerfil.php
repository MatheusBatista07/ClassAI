<!-- Popup de Perfil -->
<div id="profile-popup" class="profile-popup">
    <a href="pagina-perfil.php" class="popup-item">
        <i class="bi bi-person-fill"></i>
        <span>Perfil</span>
    </a>
    <a href="pagina-configuracoes.php" class="popup-item">
        <i class="bi bi-gear-fill"></i>
        <span>Configurações</span>
    </a>
    <a href="../logout.php" class="popup-item">
        <i class="bi bi-box-arrow-right"></i>
        <span>Sair</span>
    </a>
</div>

<style>
/* Estilos para o Popup de Perfil */
.profile-popup {
    position: absolute;
    top: 65px; /* Distância do topo */
    right: 20px; /* Distância da direita */
    width: 200px;
    background-color: #24143D; /* Roxo escuro do seu design */
    border-radius: 16px;
    border: 1px solid #4A3A69;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4), 0 0 20px 5px rgba(107, 63, 160, 0.3); /* Sombra + Brilho roxo */
    padding: 10px;
    z-index: 1000;
    display: none; /* Começa escondido */
    flex-direction: column;
    gap: 5px;
    animation: fadeIn 0.2s ease-out;
}

.profile-popup.show {
    display: flex; /* Mostra o popup */
}

.popup-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 15px;
    color: #C0B8D4; /* Cor do texto secundário */
    text-decoration: none;
    border-radius: 10px;
    font-weight: 500;
    transition: background-color 0.2s ease, color 0.2s ease;
}

.popup-item:hover {
    background-color: #3D2561; /* Roxo mais claro no hover */
    color: #FFFFFF; /* Texto branco no hover */
}

.popup-item i {
    font-size: 18px;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
