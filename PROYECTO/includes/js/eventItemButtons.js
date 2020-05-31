function deleteEvent(eventId) {
	var data = {
		"eventId": eventId
	};
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "includes/deleteEvent.php",
		data: data,
		success: result => {
			if (result == 0)
				alert("No se puede borrar este evento en este momento.");
			else
				alert("Event has been deleted");
				window.location.href = "feed.php";
		},
		error: e => {
			console.log(e);
		}
	});
}

function deleteComment() {
	var id = $(this).val();
	var comment = {
		"action": "delete",
		"commentId": id
	};
	var ok = confirm("Estas seguro?");
	if (ok) {
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "includes/processComment.php",
			data: comment,
			success: result => {
				if (result == 0)
					alert("No se puede borrar este comentario en este momento.");
				else
					$(this).parent().css("display", "none");
			},
			error: e => {
				console.log(e);
			}
		});
	}
}

function processJoinEvent(eventId, userId, action) {
	var status = 0;
	var retType = 0;
	var html = "";
	switch (action) {
		case 'cancel':
			status = 0;
			break;
		case 'reject':
			status = 0;
			break;
		case 'accept':
			status = 1;
			break;
		case 'join':
			status = 2;
			break;
	}
	var data = {
		"eventId": eventId,
		"userId": userId,
		"status": status
	}
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "includes/processJoinEvent.php",
		data: data,
		success: data => {
			if (!data)
				alert("No se puede hacer el gesto en este momento. Consulta el admin.");
			else {
				switch (action) {
					case 'cancel':
						$("#joinCancelEventBtns").empty();
						var html = '<input type="image" src="includes/img/boton_UNIRSE_2.png" class="joinEventBtn" alt="YoVoy" title="YoVoy" value="' + eventId + '">' +
							'<script> $("#joinCancelEventBtns input.joinEventBtn").click(function () {' +
							'var ok = confirm("Estas seguro?");' +
							'if (ok)' +
							'processJoinEvent($("#eventId").val(), $("#userId").val(), "join");' +
							'});</script >';
						$("#joinCancelEventBtns").append(html);
						break;
					case 'reject':
						$("#userWaitingList div div.user" + userId).remove();
						break;
					case 'accept':
						var userClass = $("#userWaitingList div div.user" + userId).hasClass('tarjeta_premium') ? 'tarjeta_premium' : 'tarjeta_blanca';
						var imgPath = $("#userWaitingList div div.user" + userId + " p img").attr("src");
						var name = $("#userWaitingList div div.user" + userId + " p a").text();
						var newAttendee = $('<div class="'+ userClass +'"<a href="profileView.php?profileId=' + userId + '"><img src="' + imgPath + '" width="20px" height="20px">' + name + '</a>  ' + formatDateWithTime(new Date()) +'</div>');
						$("#userWaitingList div div.user" + userId).remove();
						$("#attendeeList").append(newAttendee);
						break;
					case 'join':
						$("#joinCancelEventBtns").empty();
						var html = '<input type="image" src="includes/img/boton_UNIRSE_3.png" class="cancelEventBtn" alt="YaNoVoy" title="YaNoVoy" value="' + eventId + '" >' +
							'<script>$("#joinCancelEventBtns input.cancelEventBtn").click(function () {' +
							'var ok = confirm("Estas seguro?");' +
							'if (ok)' +
							'processJoinEvent($("#eventId").val(), $("#userId").val(), "cancel");' +
							'});</script>';
						$("#joinCancelEventBtns").append(html);
						break;
				}
			}
		},
		error: e => {
			console.log(e);
		}

	});
}

function promoteEvent(eventId, userId) {
	var data = {
		"eventId": eventId,
		"userId": userId
	}
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "includes/promoteEvent.php",
		data: data,
		success: data => {
			if (data == 0)
				alert("Ha habido un error. Consulta el admin.");
			else {
				var check = $("#promoteEventBtns input").hasClass('promoEventBtn');
				var before = 'promoEventBtn';
				var after = 'unpromoEventBtn';
				var imgString = 'boton_UNPROMO.png';
				var altString = 'No Promocionar';
				if (!check) {
					var temp = before;
					before = after;
					after = temp;
					var altString = 'Promocionar';
					var imgString = 'boton_PROMO.png';
				}
				var toChange = $("#promoteEventBtns input");
				toChange.removeClass(before);
				toChange.addClass(after);
				toChange.attr("src", "includes/img/" + imgString);
				toChange.attr("alt", altString);
				toChange.attr("title", altString);
			}
		},
		error: e => {
			console.log(e);
		}
	});
}

$(document).ready(function () {

	$("#submitCommentBtn").click(function () {
		var id = $(this).val();
		var text = $("#newCommentText").val().replace(/<\/?[^>]+(>|$)/g, "");
		var comment = {
			"action": "submit",
			"eventId": id,
			"commentText": text
		};
		$.ajax({
			type: "POST",
			dataType: "json",
			url: "includes/processComment.php",
			data: comment,
			success: json => {
				var newDate = formatDateWithTime(new Date());
				var newComment = $(
					'<div class="tarjeta_gris">' +
					'<p>Comentario de <a href = "profileView.php?profileId=' + json.userId + '">' + json.username + '</a> el ' + newDate + '</p>' +
					'<div class="tarjeta_blanca">' + text +
					'</div>' +
					'<input type="image"  width="15%" length="15%" src="includes/img/boton_BORRARCOMENTARIO.png" alt="Enviar Comentario" title="Enviar Comentario" class="deleteCommentBtn" type="submit" value="'+ json.id +'">' +
					'</div>' +
					'<script>$("#commentsSection input.deleteCommentBtn").click(deleteComment);</script>'
				);
				$("#newCommentText").val("");
				$("#emptyCom").hide();
				$("#commentsSection").prepend(newComment);
			},
			error: e => {
				console.log(e);
			}
        });
	});

	var eventId = $("#eventId").val();
	var userId = $("#userId").val();

	$("#joinCancelEventBtns input.cancelEventBtn").click(function () {
		var ok = confirm("¿Estas seguro?");
		if (ok)
			processJoinEvent(eventId, userId, 'cancel');
	});
	$("#joinCancelEventBtns input.joinEventBtn").click(function () {
		var ok = confirm("¿Estas seguro?");
		if (ok)
			processJoinEvent(eventId, userId, 'join');
	});
	$("#userWaitingList div div input.acceptUserBtn").click(function () {
		var ok = confirm("¿Estas seguro?");
		if (ok)
			processJoinEvent(eventId, $(this).val(), 'accept');
	});
	$("#userWaitingList div div input.rejectUserBtn").click(function () {
		var ok = confirm("¿Estas seguro?");
		if (ok)
			processJoinEvent(eventId, $(this).val(), 'reject');
	});
	$("#promoteEventBtns input").click(function () {
		var ok = confirm("¿Estas seguro?");
		if (ok)
			promoteEvent(eventId, userId);
	});

	$("#commentsSection input.deleteCommentBtn").click(deleteComment);
	
	$("#manageAuxImgBtn").click(function(){
		window.location.href = "manageAuxImg.php";
	});
	$("#deleteEventBtn").click(function () {
		var ok = confirm("¿Estas seguro?");
		if (ok)
			deleteEvent($(this).val());
	});
});