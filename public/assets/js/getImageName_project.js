const pathValueproject = document.getElementById('banner_image');
const labelText = document.getElementById('image_label');

labelText.innerHTML = '<span id="image_label" class="form-upload-span" style="color: grey">' +
    'Upload photo de profil</span>'

pathValueproject.addEventListener('change', () => {
    const pathExplodeValues = pathValueproject.value.split("\\");
    labelText.innerText = pathExplodeValues[2];
});