const uploadValue = document.getElementById('profil_picture');
const labelText = document.getElementById('image_label');

labelText.innerText = 'Upload photo de profil'

uploadValue.addEventListener('change', () => {
    console.log('value :', uploadValue.value)
    labelText.innerText = uploadValue.value;
});