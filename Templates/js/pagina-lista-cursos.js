// Aguarda o evento que sinaliza que todo o HTML foi carregado e processado
document.addEventListener('DOMContentLoaded', function () {
    
    // --- 1. Seleção dos Elementos do DOM ---
    const deleteModal = document.getElementById('deleteModal');
    const closeModalButton = document.getElementById('closeModal');
    const cancelDeleteButton = document.getElementById('cancelDelete');
    const confirmDeleteButton = document.getElementById('confirmDelete');
    const deleteButtons = document.querySelectorAll('.deletar');

    if (!deleteModal || !closeModalButton || !cancelDeleteButton || !confirmDeleteButton) {
        console.error("Erro: Um ou mais elementos do modal não foram encontrados. Verifique os IDs no HTML.");
        return;
    }

    let courseItemToDelete = null;

    // --- 2. Funções Principais ---

    const openModal = (event) => {
        // Apenas identifica qual item deve ser excluído
        courseItemToDelete = event.currentTarget.closest('.student-item');
        
        // --- LINHAS REMOVIDAS ---
        // As linhas abaixo, que pegavam o nome do curso, foram removidas.
        // const courseName = courseItemToDelete.querySelector('.student-info span').textContent;
        // const courseNameElement = deleteModal.querySelector('.course-name-modal');
        // if (courseNameElement) {
        //     courseNameElement.textContent = `"${courseName}"`;
        // }

        // Apenas exibe o modal
        deleteModal.style.display = 'flex';
    };

    const closeModal = () => {
        deleteModal.style.display = 'none';
        courseItemToDelete = null;
    };

    const handleDelete = () => {
        if (courseItemToDelete) {
            console.log('Excluindo o curso:', courseItemToDelete.querySelector('.student-info span').textContent);
            courseItemToDelete.remove();
            closeModal();
        }
    };

    // --- 3. Adição dos Event Listeners ---

    deleteButtons.forEach(button => {
        button.addEventListener('click', openModal);
    });

    closeModalButton.addEventListener('click', closeModal);
    cancelDeleteButton.addEventListener('click', closeModal);

    deleteModal.addEventListener('click', function (event) {
        if (event.target === deleteModal) {
            closeModal();
        }
    });

    confirmDeleteButton.addEventListener('click', handleDelete);
});
