function deleteUser(userId) {
	var data = {
		"userId": userId
	};
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "includes/deleteUser.php",
		data: data,
		success: result => {
			if (result != 0)
				alert("No se puede borrar el usuario en este momento.");
			else
				alert("User has been deleted");
			window.location.href = "search.php";
		},
		error: e => {
			console.log(e);
		}
	});
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
			else {
				var div = element.parent();
				div.empty();
				div.prepend(result.html);
			}
		},
		error: e => {
			console.log(e);
		}
	});
}

$(document).ready(function () {
	$("#addFriendBtn").click(function () {
		var ok = confirm("¿Estas seguro?");
		if (ok)
			changeRelation($(this), 'addFriend');
	});
	$("#cancelAddFriendBtn").click(function () {
		var ok = confirm("¿Estas seguro?");
		if (ok)
			changeRelation($(this), 'cancelAddFriend');
	});
	$("#acceptFriendBtn").click(function () {
		var ok = confirm("¿Estas seguro?");
		if (ok)
			changeRelation($(this), 'acceptFriend');
	});
	$("#rejectFriendBtn").click(function () {
		var ok = confirm("¿Estas seguro?");
		if (ok)
			changeRelation($(this), 'rejectFriend');
	});
	$("#unfriendBtn").click(function () {
		var ok = confirm("¿Estas seguro?");
		if (ok)
			changeRelation($(this), 'unfriend');
	});
	$("#blockUserBtn").click(function () {
		var ok = confirm("¿Estas seguro?");
		if (ok)
			changeRelation($(this), 'blockUser');
	});
	$("#unblockUserBtn").click(function () {
		var ok = confirm("¿Estas seguro?");
		if (ok)
			changeRelation($(this), 'unblockUser');
	});
	$("#deleteUserBtn").click(function () {
		var ok = confirm("¿Estas seguro?");
		if (ok)
			deleteUser($(this).val());
	});
});