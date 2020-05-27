function deleteImg() {
    //parse
    var ids = $(this).val().split("_");
    var eventId = ids[0];
    var imgId = ids[1];

    //call php script to delete img
    //var url = "includes/deleteImage.php?eventId=" + eventId + "&imgId=" + imgId;
    
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
				alert("Cant delete this comment at the moment.");
			else
				$(this).parent().css("display", "none");
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

    $("#deleteImgBtn").click(deleteImg);
});