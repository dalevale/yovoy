//Funciones para validar strings

function isLowerCase(str) {
    var valid = true;
    var i = 0;
    while (valid && (i < str.length)) {
        valid = str.charAt(i) == str.charAt(i).toLowerCase();
        i++;
    }
    return valid;
}

function hasPattern(str, pattern) {
    var valid = true;
    if (!str.match(pattern))
        valid = false;
    return valid;
}

function isOnlyLetters(str) {
    var valid = true;
    var letters = /^[a-zA-Z]+$/;
    var name = str.split(' ');
    var i = 0;
    while (valid && (i < name.length)) {
        if (!name[i].match(letters))
            valid = false;
        i++;
    }
    return valid;
}

//Funciones para validar formularios de registro y cambios de cuenta de usuario

//Constantes de tamaño minimo
const NAME_LENGTH = 4;
const USERNAME_LENGTH = 5;
const PASSWORD_LENGTH = 8;

function isValidUsername(uname) {
    var errMessage = '';
    if (uname == "")
        errMessage = "<p>Nombre de usuario no puede estar vacio!</p>";
    else if (!isLowerCase(uname))
        errMessage = "<p>Username - formato invalido! (Solo letras minusculas)</p>";
    else if (!hasPattern(uname, /^[0-9a-zA-Z]+$/))
        errMessage = "<p>Username - formato invalido! (Solo letras y números)</p>";
    else if (uname.length < USERNAME_LENGTH)
        errMessage = "<p>Tamaño de username tiene que ser mas de " + (USERNAME_LENGTH + 1) + " cáracteres</p>";


    return errMessage;
}

function isValidName(name) {
    var errMessage = '';
    if (name == '')
        errMessage = "<p>Nombre no puede estar vacio!</p>";
    else if (!isOnlyLetters(name))
        errMessage = "<p>Nombre invalido!</p>";
    else if (name.length < NAME_LENGTH)
        errMessage = "<p>Tamaño de username tiene que ser mas de " + (NAME_LENGTH + 1) + "cáracteres</p>";

    return errMessage;
}

function validateName(str) {
    var nameArray = str.split(' ');
    var i = 0;
    var validName = '';
    while (i < nameArray.length) {
        var nameStr = nameArray[i];
        nameFirstLetter = nameStr.charAt(0).toUpperCase();
        nameStr = nameStr.slice(1, nameStr.length).toLowerCase();
        validName += nameFirstLetter + nameStr;
        if (i != (nameArray.length - 1))
            validName += ' ';
        i++;
    }
    return validName;

}

function isValidPassword(pass1, pass2) {
    var errMess = '';
    if ((pass1 == '') || (pass2 == ''))
        errMess = "<p>Password no puede estar vacio!</p>";
    else if (pass1 != pass2)
        errMess = "<p>Confirmación de password no coincide.</p>";
    else if (pass1.length < PASSWORD_LENGTH)
        errMessage = "<p>Tamaño de password tiene que ser mas de " + (PASSWORD_LENGTH + 1) + "cáracteres</p>";


    return errMess;
}

function isValidEmail(email) {
    var errMessage = '';
    var emailStr = email.slice(0, email.indexOf('@'));
    var emailDomain = email.slice(email.indexOf('@') + 1, email.indexOf('.'));
    var emailSuffix = email.slice(email.indexOf('.'), email.length);
    if (email == "")
        errMessage = "<p>Email no puede estar vacio!</p>";
    else if (!hasPattern(emailStr, /^([a-zA-Z])[a-zA-Z0-9-_]([a-zA-Z])*$/) ||
        !hasPattern(emailDomain, /^([a-zA-Z])[a-zA-Z0-9-_]([a-zA-Z])*$/) ||
        !(emailSuffix == '.com' || emailSuffix == '.cc' || emailSuffix == '.org'))
        errMessage = "<p>Formato de email invalido!</p>";
    return errMessage;
}

//Funciones para validar formularios de creacion y cambios de eventos

//Constantes de tamaño minimo
const EVENT_NAME_LENGTH = 4;
const EVENT_TAG_LENGTH = 2;

function isValidEventName(ename) {
    var enameStrArray = ename.split(' ');
    var errMessage = '';
    if (ename == '')
        errMessage = "<p>Nombre del evento no puede estar vacio!</p>";
    else if (!hasPattern(enameStrArray[0], /^[a-zA-Z0-9]/))
        errMessage = "<p>Nombre invalido! Tiene que empezar por letras o numeros.</p>";
    else if (ename.length < EVENT_NAME_LENGTH)
        errMessage = "<p>Tamaño del nombre tiene que ser mas de " + (EVENT_NAME_LENGTH + 1) + "cáracteres</p>";

    return errMessage;
}

function isValidLocation(elocation) {
    var errMessage = '';
    if (elocation == '')
        errMessage = "<p>Ubicación del evento no puede estar vacio!</p>";
    else if (!hasPattern(elocation, /^[0-9a-zA-Z,.\s]+$/))
        errMessage = "<p>Ubicación invalido! No puede contener simbolos.</p>";

    return errMessage;
}

function isValidTags(etags) {
    etagsArray = etags.split(',');
    var errMessage = '';
    var i = 0;
    if (etags != '') {
        while ((i < etagsArray.length) && errMessage == '') {
            var tagsWithSpaces = etagsArray[i].split(' ');
            if (tagsWithSpaces.length > 1)
                errMessage = "<p>Cada tag separado por ',' no puede tener dos palabras!</p>";
            else if (!hasPattern(etagsArray[i], /^[0-9a-zA-Z]+$/)) {
                errMessage = "<p>Tags invalidos! No puede contener simbolos.</p>";
            }
            else if (etagsArray[i].length < EVENT_NAME_LENGTH)
                errMessage = "<p>Tamaño de cada tag tiene que ser mas de " + (EVENT_TAG_LENGTH + 1) + "cáracteres</p>";
            i++;
        }
    }

    return errMessage;
}