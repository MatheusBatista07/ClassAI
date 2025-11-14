document.addEventListener('DOMContentLoaded', function () {

    // --- DADOS VINDOS DO "BANCO DE DADOS" (Simulação) ---
    // Em um cenário real, você receberia este array via fetch() de uma API PHP/Node.js
    const modulesData = [
        {
            id: 101,
            moduleNumber: 1,
            title: "Fundamentos do ChatGPT e Aplicações no Dia a Dia",
            duration: "1h30",
            coverImage: "https://i.imgur.com/vG3G41b.jpeg", // URL da imagem do módulo 1
            coverTitle: "FUNDAMENTOS"
        },
        {
            id: 102,
            moduleNumber: 2,
            title: "Automatizando Tarefas com Texto e Criatividade",
            duration: "2h",
            coverImage: "https://i.imgur.com/v8e2d9d.jpeg", // URL da imagem do módulo 2
            coverTitle: "Automatizando Tarefas com Texto e Criatividade"
        }
        // Adicione mais objetos de módulo aqui conforme necessário
    ];

    const modulesGrid = document.getElementById('modules-grid' );

    // --- FUNÇÃO PARA GERAR OS CARDS NA PÁGINA ---
    function renderModules() {
        modulesGrid.innerHTML = ''; // Limpa o grid antes de renderizar
        modulesData.forEach(module => {
            const card = document.createElement('div');
            card.className = 'module-card';
            // Adiciona o ID do módulo ao elemento do card para fácil identificação
            card.dataset.moduleId = module.id; 

            card.innerHTML = `
                <div class="card-header">
                    <img src="${module.coverImage}" alt="Capa do ${module.title}">
                    <div class="edit-module-btn">
                        <i class="bi bi-pencil-fill"></i>
                    </div>
                </div>
                <div class="card-body">
                    <p>Módulo ${module.moduleNumber}</p>
                    <h3>${module.title}</h3>
                </div>
                <div class="card-footer">
                    <i class="bi bi-clock"></i>
                    <span>Duração estimada: ${module.duration}</span>
                </div>
            `;
            modulesGrid.appendChild(card);
        });
    }

    // --- LÓGICA DO MODAL DE EDIÇÃO ---
    const modal = document.getElementById('editModuleModal');
    const closeModalBtn = document.getElementById('closeModal');
    const editForm = document.getElementById('editModuleForm');
    
    // Inputs do formulário do modal
    const moduleIdInput = document.getElementById('editing-module-id');
    const moduleTitleInput = document.getElementById('module-title');
    const moduleDurationInput = document.getElementById('module-duration');
    const modalCoverImage = document.getElementById('modal-cover-image');
    const modalCoverUpload = document.getElementById('modal-cover-upload');

    // Abre o modal ao clicar no botão de lápis
    modulesGrid.addEventListener('click', function(event) {
        const editButton = event.target.closest('.edit-module-btn');
        if (editButton) {
            const card = editButton.closest('.module-card');
            const moduleId = parseInt(card.dataset.moduleId);
            
            // Encontra os dados do módulo clicado
            const moduleData = modulesData.find(m => m.id === moduleId);

            if (moduleData) {
                // Preenche o formulário do modal com os dados do módulo
                moduleIdInput.value = moduleData.id;
                moduleTitleInput.value = moduleData.title;
                moduleDurationInput.value = moduleData.duration;
                modalCoverImage.src = moduleData.coverImage;
                
                modal.style.display = 'flex'; // Mostra o modal
            }
        }
    });

    // Fecha o modal
    const closeModal = () => {
        modal.style.display = 'none';
    };
    closeModalBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (event) => {
        if (event.target === modal) {
            closeModal();
        }
    });

    // Pré-visualização da nova imagem da capa no modal
    modalCoverUpload.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = e => modalCoverImage.src = e.target.result;
            reader.readAsDataURL(file);
        }
    });

    // Lida com o envio do formulário de edição
    editForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Impede o recarregamento da página

        const formData = new FormData(editForm);
        
        // Em um cenário real, você enviaria 'formData' para o seu back-end via fetch()
        // fetch('seu-script-de-update.php', { method: 'POST', body: formData })
        //     .then(response => response.json())
        //     .then(data => { ... });

        console.log("--- Formulário Enviado (Simulação) ---");
        console.log("ID do Módulo a ser atualizado:", formData.get('moduleId'));
        console.log("Novo Título:", formData.get('moduleTitle'));
        console.log("Nova Duração:", formData.get('moduleDuration'));
        console.log("Nova Imagem:", formData.get('moduleCover')); // Este é um objeto File

        // Simulação de atualização dos dados e re-renderização
        const updatedId = parseInt(formData.get('moduleId'));
        const moduleIndex = modulesData.findIndex(m => m.id === updatedId);
        if (moduleIndex !== -1) {
            modulesData[moduleIndex].title = formData.get('moduleTitle');
            modulesData[moduleIndex].duration = formData.get('moduleDuration');
            // Se uma nova imagem foi selecionada, atualiza a URL (simulação)
            if (formData.get('moduleCover').size > 0) {
                modulesData[moduleIndex].coverImage = URL.createObjectURL(formData.get('moduleCover'));
            }
        }
        
        closeModal(); // Fecha o modal
        renderModules(); // Re-renderiza os cards com os dados atualizados
        
        alert("Módulo atualizado com sucesso! (Simulação)");
    });

    // --- INICIALIZAÇÃO ---
    renderModules(); // Chama a função para criar os cards quando a página carrega
});
