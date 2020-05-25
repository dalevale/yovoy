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
						var html = '<button type="button" class="joinEventBtn" value="' + eventId + '">YoVoy</button>' +
							'<script> $("#joinCancelEventBtns button.joinEventBtn").click(function () {' +
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
						var html = '<button type = "button" class="cancelEventBtn" value = "' + eventId + '" > YaNoVoy</button >' +
							'<script>$("#joinCancelEventBtns button.cancelEventBtn").click(function () {' +
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
			var check = $("#promoteEventBtns button").hasClass('promoEventBtn');
			var before = 'promoEventBtn';
			var after = 'unpromoEventBtn';
			var string = 'No Promocionar';
			if (!check) {
				var temp = before;
				before = after;
				after = temp;
				var string = 'Promocionar';
			}
			$("#promoteEventBtns button").removeClass(before);
			$("#promoteEventBtns button").addClass(after);
			$("#promoteEventBtns button").text(string);
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
				var newDate = formatDateWithTime(new Date());
				var newComment = $(
					'<div class="tarjeta_gris">' +
					'<p>Comentario de <a href = "profileView.php?profileId=' + json.userId + '">' + json.username + '</a> el ' + newDate + '</p>' +
					'<div class="tarjeta_blanca">' +
					text +
					'</div>' +
					'<button class="deleteCommentBtn" type="submit" value="'+ json.id +'">Borrar comentario</button>' +
					'</div>' +
					'<script>$("#commentsSection button.deleteCommentBtn").click(deleteComment);</script>'
				);
				$("#newCommentText").val("");
				$("#commentsSection").prepend(newComment);
			},
			error: e => {
				console.log(e);
			}
        });
	});

	var eventId = $("#eventId").val();
	var userId = $("#userId").val();

	$("#joinCancelEventBtns button.cancelEventBtn").click(function () {
		processJoinEvent(eventId, userId, 'cancel');
	});
	$("#joinCancelEventBtns button.joinEventBtn").click(function () {
		processJoinEvent(eventId, userId, 'join');
	});
	$("#userWaitingList div div button.acceptUserBtn").click(function () {
		processJoinEvent(eventId, $(this).val(), 'accept');
	});
	$("#userWaitingList div div button.rejectUserBtn").click(function () {
		processJoinEvent(eventId, $(this).val(), 'reject');
	});
	$("#promoteEventBtns button").click(function () {
		promoteEvent(eventId, userId);
	});


	$("#commentsSection button.deleteCommentBtn").click(deleteComment);
	
});