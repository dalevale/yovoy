const form = document.getElementsByTagName('form')[0];

const email = document.getElementById('email');
const emailError= document.querySelector('email + span.error');

email.addEventListener('input', function(event){

    if(email.validity.valid){
        emailError.innerHTML = '';
        emailError.className = 'error';
    }
    else{
        showError();
    }
}
);

form.addEventListener('submit', function(event){

    if(!email.validity.valid){
        showError();
        event.prevventDefault();
    }
});

function showError(){
    if(email.validity.valueMissing){
        emailError.textContent = 'Debe de introducir una dirección de correo electrónico válido';
    }
    else if(email.validity.typeMismatch){
        emailError.textContent = 'El valor introducido debe ser una dirección de correo electrónico';
    }

    emailError.className = 'error activo';
}