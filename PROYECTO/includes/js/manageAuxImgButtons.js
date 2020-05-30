function deleteImg(eventId, imgId) {
    
    //parse
    var ids = $(this).val().split("_");
    var eventId = ids[0];
    var imgId = ids[1];
    
    var input = {
        "event_id"  : eventId,
        "img_id"    : imgId
    };

	$.ajax({
		type: "POST",
		dataType: "json",
		url: "includes/deleteImage.php",
		data: input,
		success: result => {
			if (result == 0)
				alert("No se puede borrar imagen en este momento. Consulta el admin.");
            else
                //ARREGLAR ESTO
                $(this).parent().css("display", "none");
                //window.location.reload(true);
		},
		error: e => {
			console.log(e);
		}
	});
}

$(document).ready(function () {
    $("#addImgBtn").click(function(){
        window.location.href = "addImage.php";
    });

    $(".deleteImgBtn").click(deleteImg);
});