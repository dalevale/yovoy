var validateLogin = function (event) {
    valid = true;
    document.getElementById('printError').innerHTML = '';
    var u = document.getElementById('printError');
    var email = loginForm['email'].value;
    var password = loginForm['password'].value;
    var validEmail = isValidEmail(email);
    var validPassword = isEmpty(password);
    if (validEmail != '') {
        var l = document.createElement('LI');
        l.innerHTML = validEmail;
        u.append(l);
        valid = false;
    }
    if (validPassword == '') {
        var l = document.createElement('LI');
        l.innerHTML = "<p>Password no puede estar vacio!</p>";
        u.append(l);
        valid = false;
    }
    if (!valid) {
        event.preventDefault();
        u.style.display = "block";
        u.scrollIntoView();
    }
};

window.onload = function () {
    //Validacion de formulario de login
    var loginForm = document.getElementById('loginForm');
    loginForm.addEventListener('submit', validateLogin);

};