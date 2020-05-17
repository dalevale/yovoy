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

	$("#deleteCommentBtn").click(deleteComment);
	
});