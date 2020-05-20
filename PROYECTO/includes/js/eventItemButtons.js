function formatDate (d) {
	var date = new Date(d);
	var yr = date.getFullYear();
	var month = date.getMonth() > 8 ? (date.getMonth() + 1) : '0' + (date.getMonth() + 1);
	var day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
	var newDate = day + '-' + month + '-' + yr;
	return newDate;
}

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

function processJoinEvent(element, task) {
	var eventId = $("#eventId").val();
	var userId = element.val();
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
						var html = '<button type="button" id="joinEventBtn" value="' + eventId + '">Join Event</button>' +
							'<script> $("#joinEventBtn").click(function () {' +
							'processJoinEvent($(this), "join");' +
							'});</script >';
						$("#joinCancelEventBtns").append(html);
						break;
					case 'reject':
					case 'accept':
						var imgPath = $("#userWaitingList div div.user" + userId + " p img").attr("src");
						var name = $("#userWaitingList div div.user" + userId + " p a").text();
						var newAttendee = $('<a href="profileView.php?profileId=' + userId + '"><p><img src="' + imgPath + '" width="20px" height="20px">' + name + '</p></a>');
						$("#attendeeList").append(newAttendee);
						$("#userWaitingList div div.user" + userId).remove();
						break;
					case 'join':
						$("#joinCancelEventBtns").empty();
						var html = '<p>Esperando respuesta del organizador...</p>' +
							'<button type = "button" id = "cancelEventBtn" value = "' + eventId + '" > YaNoVoy</button >' +
							'<script>$("#cancelEventBtn").click(function () {' +
							'processJoinEvent($(this), "cancel");' +
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

$(document).ready(function () {

	$("#submitCommentBtn").click(function () {
		var id = $(this).val();
		var text = $("#newCommentText").val();
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
				var newDate = formatDate(new Date());
				var newComment = $(
					'<div class="tarjeta_gris">' +
					'<p>Comentario de <a href = "profileView.php?profileId=' + json.userId + '">' + json.username + '</a> el ' + newDate + '</p>' +
					'<div class="tarjeta_blanca">' +
					text +
					'</div>' +
					'<button id="deleteCommentBtn" type="submit" value="'+ json.id +'">Borrar comentario</button>' +
					'</div>' +
					'<script>$("#deleteCommentBtn").click(deleteComment);</script>'
				);
				$("#newCommentText").val("");
				$("#commentsSection").prepend(newComment);
			},
			error: e => {
				console.log(e);
			}
        });
	});

	$("#cancelEventBtn").click(function () {
		processJoinEvent($(this), 'cancel');
	});
	$("#joinEventBtn").click(function () {
		processJoinEvent($(this), 'join');
	});
	$("#acceptUserBtn").click(function() {
		processJoinEvent($(this), 'accept');
	});
	$("#rejectUserBtn").click(function () {
		processJoinEvent($(this), 'reject');
	});


	$("#deleteCommentBtn").click(deleteComment);
	
});