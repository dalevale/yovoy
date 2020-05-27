var validate = function (event) {

    var valid = true;
    var eventName = editEventForm["eventName"].value.replace(/<\/?[^>]+(>|$)/g, "");
    var eventLocation = editEventForm["eventLocation"].value.replace(/<\/?[^>]+(>|$)/g, "");
    var eventTags = editEventForm["eventTags"].value.replace(/<\/?[^>]+(>|$)/g, "");
    var eventDescription = editEventForm["description"].value.replace(/<\/?[^>]+(>|$)/g, "");
    var u = document.getElementById('printError');
    u.innerHTML = '';
    var formArray = {
        vEventName: isValidEventName(eventName),
        vEventLocation: isValidLocation(eventLocation),
        vEventTags: isValidTags(eventTags),
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
}

var cancel = function (event) {
    event.preventDefault();
    window.location.href = "events.php";
}
var reset = function (event) {
    event.preventDefault();
    var i = 0;
    for (i = 0; i < editEventForm.length; i++)
        editEventForm[i].value = '';
    editEventForm["eventDate"].value = "2020-01-01";
    editEventForm["maxAssistants"].value = 1;
}

//Validacion de formulario de registrar
var editEventForm = document.getElementById('editEventForm');
var resetBtn = document.getElementById('editEventFormReset');
var cancelBtn = document.getElementById('editEventFormCancel')
editEventForm.addEventListener('submit', validate);
resetBtn.addEventListener('click', reset);
cancelBtn.addEventListener('click', cancel);