function searchUserAdmin(data) {
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "includes/searchUser.php",
        data: data,
        success: ret => {
            $("#searchUserAdmin div.searchList").remove();
            var newList = $('<div class="searchList tarjeta_blanca"></div>');
            if (ret.length == 0) {
                newList.append($("</p>No existe este usuario.<p>"));
                $("#searchUserAdmin").append(newList);
            }
            else {
                for (var i = 0; i < ret.length; i++) {
                    var user = ret[i];
                    var userImgName = user.imgName;
                    var name = data.filter == "name" ? user.name : user.username;
                    var userImgDir = "includes/img/users/";
                    var userImgPath = userImgDir + userImgName;
                    var row = '<a href="profileView.php?profileId=' + user.id + '"><img src = "' + userImgPath + '?random=' + Math.random(0, 100000) + '" alt = "event" height = "50" width = "50" ></a> ' +
                        '<a href="profileView.php?profileId=' + user.id + '">' + name + '</a>';
                    newList.append($(row));
                }
                $("#searchUserAdmin").append(newList);
            }
        },
        error: e => {
            console.log(e);
        }
    });
}

function printEventAdmin(data) {
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "includes/getEvents.php",
        data: data,
        success: data => {
            $("#searchEventAdmin div.searchList").remove();
            var newList = $('<div class="searchList tarjeta_blanca"></div>');
            if (data.length == 0)
                newList.append($("<p>0 Resultados</p>"));
            else {
                for (var i = 0; i < data.length; i++) {
                    var event = data[i];
                    var eventImgName = event.eventImgName;
                    var eventImgDir = "includes/img/events/";
                    var eventImgPath = eventImgDir + eventImgName;
                    var toAppend = $(
                        '<a href="eventItem.php?eventId=' + event.id + '">' +
                        '<img src="' + eventImgPath + '?random=' + Math.random(0, 100000) + ' alt="event" height="50" width="50">' +
                        '<div class=" nombreEvento">' + event.name + '</div>' +
                        '  Fecha: ' + event.date + '  ' +
                        'Aforo: ' + event.capacity + ' ' +
                        '</a>');
                    newList.append(toAppend);
                }
            }
            $("#searchEventAdmin").append(newList);
        },
        error: e => {
            console.log(e);
        }
    });
}

function searchEventAdmin() {
    var selected = $("#searchEventAdmin p input[name='eventOption']:checked").val();
    var searchVal = selected == null ? null : $("#searchEventAdmin p input[type='text']").val();
    if (searchVal == '')
        alert("El campo de busqueda ha de tener algo escrito");
    else {
        var data = {
            "filter": selected,
            "searchVal": searchVal
        };
        printEventAdmin(data);
    }
}

$(document).ready(function () {
    $("#resetSearchEventAdminBtn").click(function () {
        $("#searchEventAdmin p input[name='eventOption']:checked").prop("checked", false);
        $("#searchEventAdmin p input[type='text']").val("");
    });
    $("#searchEventAdminBtn").click(function () {
        searchEventAdmin();
    });

    $("#searchUserBtnAdmin").click(function () {
        var selected = $("#searchUserAdmin p input[name='userOption']:checked").val();
        var searchVal = $("#searchUserInputAdmin").val().replace(/<\/?[^>]+(>|$)/g, "");
        var data = {
            "filter": selected,
            "searchVal": searchVal
        };
        $("#searchUserAdmin div.err").remove();
        if (selected == 'name')
            var errMessage = isValidName(searchVal)
        else if (selected == 'username')
            var errMessage = isValidUsername(searchVal);

        if (errMessage == '') 
            searchUserAdmin(data);
        else {
            var errDiv = $('<div class="err tarjeta_blanca"><p>' + errMessage + '</p></div>');
            $("#searchUserAdmin").append(errDiv);
        }
    });
});