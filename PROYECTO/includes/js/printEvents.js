function printEvent(data) {
    $.ajax({
        type: "POST",
        dataType: "json",
        url: "includes/getEvents.php",
        data: data,
        success: data => {
            $("#eventList").empty();
            if (data.length == 0) {
                var div = $('<div class="tarjeta_blanca"><p>0 resultados</p></div>');
                $("#eventList").append(div);
            }
            else {
                for (var i = 0; i < data.length; i++) {
                    var event = data[i];
                    var eventImgName = event.eventImgName;
                    var eventImgDir = "includes/img/events/";
                    var eventImgPath = eventImgDir + eventImgName;
                    var toAppend = $(
                        '<div class = "eventos col-md-3 col-12">' +
                        '<a href="eventItem.php?eventId=' + event.id + '">' +
                        '<img src="' + eventImgPath + '?random=' + Math.random(0, 100000) + ' alt="event" height="50" width="50">' +
                        '<div class=" nombreEvento">' + event.name + '</div>' +
                        '  Fecha: ' + event.date + '  ' +
                        'Aforo: ' + event.capacity + ' ' +
                        '</a></div>');
                    $("#eventList").append(toAppend);
                }
            }
        },
        error: e => {
            console.log(e);
        }
    });
}

function searchEvent() {
    var selected = $("#searchbar p input[name='option']:checked").val();
    var filter = selected != null ? selected : "latest";
    var searchVal = selected == null ? null : $("#searchbar p input[type='text']").val();
    var data = {
        "filter": filter,
        "searchVal": searchVal
    };
    if (selected != null && searchVal == null)
        alert("El campo de busqueda ha de tener algo escrito");
    else
        printEvent(data);
}

$(document).ready(function () {
    searchEvent();
    $("#resetSearchEventBtn").click(function () {
        $("#searchbar p input[name='option']:checked").prop("checked", false);
        $("#searchbar p input[type='text']").val("");
    });
    $("#searchEventBtn").click(function () {
        searchEvent();
    });
});