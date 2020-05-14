const pathValue = document.getElementById('profil_picture');
const labelText = document.getElementById('image_label');

labelText.innerHTML = '<span id="image_label" class="form-upload-span" style="color: grey">' +
    'Upload photo de profil</span>';


pathValue.addEventListener('change', () => {
    const pathExplodeValues = pathValue.value.split("\\");
    labelText.innerText = pathExplodeValues[2];
});

const pathValue2 = document.getElementById('banner_image');
const labelText2 = document.getElementById('image_label2');

labelText2.innerHTML = '<span id="image_label2" class="form-upload-span" style="color: grey">' +
    'Upload photo de bannière</span>';

pathValue2.addEventListener('change', () => {
    const pathExplodeValues2 = pathValue2.value.split("\\");
    labelText2.innerText = pathExplodeValues2[2];
});
