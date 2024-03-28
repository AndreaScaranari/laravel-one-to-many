const placeholder = 'https://marcolanci.it/boolean/assets/placeholder.png';
const imageField = document.getElementById('image');
const previewField = document.getElementById('preview');


// Gestione preview immagine
let blobUrl;

imageField.addEventListener('change', () => {
    if (imageField.files && imageField.files[0]) {
        const file = imageField.files[0];
        const blobUrl = URL.createObjectURL(file);
        previewField.src = blobUrl;
    }
    else {
        previewField.src = placeholder;
    }
})

window.addEventListener('beforeunload', () => {
    if (blobUrl) URL.revokeObjectURL(blobUrl);
})

// Gestione input per preview immagine
const oldImgField = document.getElementById('old-img-field');
const changeImageButton = document.getElementById('change-image-button');

changeImageButton.addEventListener('click', () => {
    oldImgField.classList.add('d-none');
    imageField.classList.remove('d-none');
    previewField.src = placeholder;
    imageField.click();
})