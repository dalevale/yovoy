function appendNewButtons(element, html) {
	var div = element.parent().parent();
	div.children().eq(0).css("display", "none");
	div.prepend(html);
}

function changeRelation(element, task) {
	var userId = $("#userId").val();
	var profileId = element.val();
	var data = {
		"task": task,
		"userId": userId,
		"profileId": profileId
	};
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "includes/relationHandler.php",
		data: data,
		success: result => {
			if ((result == '') || (result == null) || (result == 0))
				alert("Cant do action at the moment.");
			else
				appendNewButtons(element, result.html);
		},
		error: e => {
			console.log(e);
		}
	});
}

$(document).ready(function () {
	$("#addFriendBtn").click(function () {
		changeRelation($(this), 'addFriend');
	});
	$("#cancelAddFriendBtn").click(function () {
		changeRelation($(this), 'cancelAddFriend');
	});
	$("#acceptFriendBtn").click(function () {
		changeRelation($(this), 'acceptFriend');
	});
	$("#rejectFriendBtn").click(function () {
		changeRelation($(this), 'rejectFriend');
	});
	$("#unfriendBtn").click(function () {
		changeRelation($(this), 'unfriend');
	});
	$("#blockUserBtn").click(function () {
		changeRelation($(this), 'blockUser');
	});
	$("#unblockUserBtn").click(function () {
		changeRelation($(this), 'unblockUser');
	});

});