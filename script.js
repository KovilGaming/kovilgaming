
const mediaItems = document.querySelectorAll('.photo-item img');
const modalContainer = document.querySelector('.modal-container');
const modalImage = document.querySelector('.modal-image');

mediaItems.forEach((media) => {
    media.addEventListener('click', () => {
        modalImage.src = media.src;
        modalContainer.style.display = 'flex';
    });
});


const closeButton = document.querySelector('.close-button');
closeButton.addEventListener('click', () => {
    modalContainer.style.display = 'none';
});

window.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        modalContainer.style.display = 'none';
    }
});


modalContainer.addEventListener('click', (event) => {
    if (event.target === modalContainer) {
        modalContainer.style.display = 'none';
    }
});


const fileUpload = document.getElementById('media-upload');
const filename = document.getElementById('filename');

fileUpload.addEventListener('change', (event) => {
    const selectedFile = event.target.files[0];
    filename.textContent = selectedFile.name;
});


const uploadIcon = document.querySelector('.upload-icon');

uploadIcon.addEventListener('click', () => {
    fileUpload.click();
});
