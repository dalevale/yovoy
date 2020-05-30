var cancel = function (event) {
    event.preventDefault();
    window.location.href = "manageAuxImg.php";
}

var cancelButton = document.getElementById("cancelBtn");
cancelButton.addEventListener('click', cancel);