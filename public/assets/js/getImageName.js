const uploadValue = document.getElementById('profil_picture');
const labelText = document.getElementById('image_label');

labelText.innerText = 'Choisir une image'

uploadValue.addEventListener('change', () => {
    console.log('value :', uploadValue.value)
    labelText.innerText = uploadValue.value;
});