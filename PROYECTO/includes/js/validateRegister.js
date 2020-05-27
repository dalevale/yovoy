var reset = function (event) {
    event.preventDefault();
    var i = 0;
    for (i = 0; i < registerForm.length; i++)
        registerForm[i].value = '';
}

var validate = function (event) {
    var valid = true;
    var uname = registerForm["username"].value.replace(/<\/?[^>]+(>|$)/g, "");
    var name = registerForm["name"].value.replace(/<\/?[^>]+(>|$)/g, "");
    var email = registerForm["email"].value.replace(/<\/?[^>]+(>|$)/g, "");
    var pass = registerForm["password"].value.replace(/<\/?[^>]+(>|$)/g, "");
    var passConf = registerForm["passwordConfirm"].value.replace(/<\/?[^>]+(>|$)/g, "");
    var u = document.getElementById('printError');
    u.innerHTML = '';
    var formArray = {
        vUsername: isValidUsername(uname),
        vName: isValidName(name),
        vPassword: isValidPassword(pass, passConf),
        vEmail: isValidEmail(email)
    }
    for (var obj in formArray) {
        if (formArray.hasOwnProperty(obj)) {
            if (formArray[obj] != '') {
                var l = document.createElement('LI');
                l.innerHTML = formArray[obj];
                u.append(l);
                valid = false;
            }
        }
    }
    if (valid != true) {
        event.preventDefault();
        u.style.display = "block";
        u.scrollIntoView();
    }
    else
        registerForm["name"].value = validateName(name);
}
//Validacion de formulario de registrar
var registerForm = document.getElementById('registerForm');
var reset = document.getElementById('registerReset');
registerForm.addEventListener('submit', validate);
reset.addEventListener('click', reset);