document.addEventListener('DOMContentLoaded', () => {
    const popupOverlay = document.getElementById('popup-overlay');
    const closePopupButton = document.getElementById('close-popup');
    const copyButton = document.getElementById('copy-button');
    const linkInput = document.getElementById('link-para-copiar');
    const copyFeedback = document.getElementById('copy-feedback');

    const openPopupButton = document.getElementById('pop-up-indique');

    const showPopup = () => {
        if (popupOverlay) {
            popupOverlay.classList.add('show');
        }
    };

    const hidePopup = () => {
        if (popupOverlay) {
            popupOverlay.classList.remove('show');
            if (copyFeedback) {
                copyFeedback.textContent = '';
            }
        }
    };

    if (openPopupButton) {
        openPopupButton.addEventListener('click', (event) => {
            event.preventDefault();
            showPopup();
        });
    }

    if (closePopupButton) {
        closePopupButton.addEventListener('click', hidePopup);
    }

    if (popupOverlay) {
        popupOverlay.addEventListener('click', (event) => {
            if (event.target === popupOverlay) {
                hidePopup();
            }
        });
    }

    if (copyButton) {
        copyButton.addEventListener('click', () => {
            try {
                navigator.clipboard.writeText(linkInput.value).then(() => {
                    copyFeedback.textContent = 'Copiado!';
                    setTimeout(() => {
                        copyFeedback.textContent = '';
                    }, 2000);
                });
            } catch (err) {
                linkInput.select();
                document.execCommand('copy');
                copyFeedback.textContent = 'Copiado!';
                setTimeout(() => {
                    copyFeedback.textContent = '';
                }, 2000);
            }
        });
    }
    const nativeShareButton = document.getElementById('native-share-btn');

    if (nativeShareButton) {
        nativeShareButton.addEventListener('click', async (event) => {
            event.preventDefault();

            const shareData = {
                title: 'ClassAI: O Futuro do Trabalho',
                text: 'Encontrei essa plataforma incrível para aprender sobre Inteligência Artificial. Venha conhecer!',
                url: linkInput.value
            };

            if (navigator.share) {
                try {
                    await navigator.share(shareData);
                    console.log('Página compartilhada com sucesso!');
                } catch (err) {
                    console.log('O usuário cancelou o compartilhamento.');
                }
            } else {
                alert('Seu navegador não suporta o compartilhamento direto. O link será copiado para a área de transferência.');
                copyButton.click();
            }
        });
    }
});