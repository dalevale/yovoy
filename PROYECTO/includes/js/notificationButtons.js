function manageNotif(action, element, toUpdate) {
	var data = {
		"notifId": element.val(),
		"action": action
	}
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "includes/processNotification.php",
		data: data,
		success: data => {
			if (action == 'delete')
				toUpdate.remove();
			else {
				//var element = $("#markNotifBtns button");
				var check = element.hasClass('markAsReadBtn');
				var before = 'markAsReadBtn';
				var after = 'markAsNoReadBtn';
				var string = 'Marcar como no leído';
				if (!check) {
					var temp = before;
					before = after;
					after = temp;
					var string = 'Marcar como leído';
					toUpdate.children().eq(0).prepend('<div class="notificationLeft" id="circle"></div>');
				}
				else
					toUpdate.children().eq(0).children().eq(0).remove();
				element.removeClass(before);
				element.addClass(after);
				element.text(string);
			}
			
		},
		error: e => {
			console.log(e);
		}
	});
}



$(document).ready(function () {

	$("#notifStart div div.notificationRight div.notifBtns button.markAsReadBtn").click(function () {
		var toUpdate = $(this).parent().parent().parent();
        manageNotif('mark', $(this), toUpdate);
	});

	$("#notifStart div div.notificationRight div.notifBtns button.markAsNotReadBtn").click(function () {
		var toUpdate = $(this).parent().parent().parent();
		manageNotif('mark', $(this), toUpdate);
	});

	$("#notifStart div div.notificationRight div.notifBtns button.deleteNotifBtn").click(function () {
		var toDelete = $(this).parent().parent().parent();
		manageNotif('delete', $(this), toDelete);
	});

});