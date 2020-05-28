function deleteComment() {
	var id = $(this).val();
	var comment = {
		"function": "delete",
		"commentId": id
	};
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "includes/processComment.php",
		data: comment,
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

function processJoinEvent(eventId, userId, task) {
	var status = 0;
	var retType = 0;
	var html = "";
	switch (task) {
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
				console.log(data);
			else {
				switch (task) {
					case 'cancel':
						$("#joinCancelEventBtns").empty();
						var html = '<input type="image" src="includes/img/boton_UNIRSE_2.png" class="joinEventBtn" alt="YoVoy" title="YoVoy" value="' + eventId + '">' +
							'<script> $("#joinCancelEventBtns input	.joinEventBtn").click(function () {' +
							'processJoinEvent($("#eventId").val(), $("#userId").val(), "join");' +
							'});</script >';
						$("#joinCancelEventBtns").append(html);
						break;
					case 'reject':
						$("#userWaitingList div div.user" + userId).remove();
						break;
					case 'accept':
						var imgPath = $("#userWaitingList div div.user" + userId + " p img").attr("src");
						var name = $("#userWaitingList div div.user" + userId + " p a").text();
						var newAttendee = $('<a href="profileView.php?profileId=' + userId + '"><p><img src="' + imgPath + '" width="20px" height="20px">' + name + '</a>  ' + formatDateWithTime(new Date()) +'</p>');
						$("#userWaitingList div div.user" + userId).remove();
						$("#attendeeList").append(newAttendee);
						break;
					case 'join':
						$("#joinCancelEventBtns").empty();
						var html = '<input type="image" src="includes/img/boton_UNIRSE_3.png" class="cancelEventBtn" alt="YaNoVoy" title="YaNoVoy" value="' + eventId + '" >' +
							'<script>$("#joinCancelEventBtns input.cancelEventBtn").click(function () {' +
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
			var check = $("#promoteEventBtns input").hasClass('promoEventBtn');
			var before = 'promoEventBtn';
			var after = 'unpromoEventBtn';
			var imgString = 'boton_UNPROMO.png';
			var altString = 'No Promocionar';
			if (!check) {
				var temp = before;
				before = after;
				after = temp;
				var imgString = 'boton_PROMO.png';
			}
			var toChange = $("#promoteEventBtns input");
			toChange.removeClass(before);
			toChange.addClass(after);
			toChange.attr("src", "includes/img/" + imgString);
			toChange.attr("alt", altString);
			toChange.attr("title", altString);
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
			"function": "submit",
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
					'<div class="tarjeta_blanca">' +
					text +
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
		processJoinEvent(eventId, userId, 'cancel');
	});
	$("#joinCancelEventBtns input.joinEventBtn").click(function () {
		processJoinEvent(eventId, userId, 'join');
	});
	$("#userWaitingList div div input.acceptUserBtn").click(function () {
		processJoinEvent(eventId, $(this).val(), 'accept');
	});
	$("#userWaitingList div div input.rejectUserBtn").click(function () {
		processJoinEvent(eventId, $(this).val(), 'reject');
	});
	$("#promoteEventBtns input").click(function () {
		promoteEvent(eventId, userId);
	});


	$("#commentsSection input.deleteCommentBtn").click(deleteComment);
	
	$("#manageAuxImgBtn").click(function(){
		window.location.href = "manageAuxImg.php";
	});
});