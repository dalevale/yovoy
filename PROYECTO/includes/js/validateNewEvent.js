var validate = function (event) {
    
    event.preventDefault();
    var valid = false;
    var eventName = editEventForm["eventName"].value;
    var eventLocation = editEventForm["eventLocation"].value;
    var eventTags = editEventForm["eventTags"].value;
    var eventDescription = editEventForm["description"].value;
    var u = document.getElementById('printError');
    u.innerHTML = '';
    var formArray = {
        vEventName : isValidEventName(eventName),
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
var editEventForm = document.getElementById('newEventForm');
var resetBtn = document.getElementById('newEventFormReset');
var cancelBtn = document.getElementById('newEventFormCancel')
editEventForm.addEventListener('submit', validate);
resetBtn.addEventListener('click', reset);
cancelBtn.addEventListener('click', cancel);