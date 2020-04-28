const pathValue = document.getElementById('profil_picture');
const labelText = document.getElementById('image_label');

labelText.innerHTML = '<span id="image_label" class="form-upload-span" style="color: grey">' +
    'Upload photo de profil</span>'

pathValue.addEventListener('change', () => {
    const pathExplodeValues = pathValue.value.split("\\");
    labelText.innerText = pathExplodeValues[2];
});