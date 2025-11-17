const inputCover = document.getElementById('course-cover');
const previewCover = document.getElementById('preview-cover');

inputCover.addEventListener('change', function () {
    const file = this.files[0];

    if (file) {
        const reader = new FileReader();

        reader.onload = function (e) {
            previewCover.src = e.target.result;
            previewCover.classList.remove('d-none'); // mostra a imagem
        };

        reader.readAsDataURL(file);
    }
});
const plusIcon = document.querySelector('.cover-upload-area i');

reader.onload = function (e) {
    previewCover.src = e.target.result;
    previewCover.classList.remove('d-none');
    plusIcon.style.display = "none"; // some com o +
};
