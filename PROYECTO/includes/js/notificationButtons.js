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
			if (data == 0)
				alert("Ha habido un error. Consulta el admin.");
			else if (action == 'delete')
				toUpdate.remove();
			else {
				var check = element.hasClass('markAsReadBtn');
				var before = 'markAsReadBtn';
				var after = 'markAsNoReadBtn';
				var altString = 'Marcar como no leído';
				var imgString = 'includes/img/boton_NOLEIDO.png';
				if (!check) {
					var temp = before;
					before = after;
					after = temp;
					var altString = 'Marcar como leído';
					var imgString = 'includes/img/boton_LEIDO.png';
					toUpdate.children().eq(0).prepend('<div class="notificationLeft" id="circle"></div>');
				}
				else
					toUpdate.children().eq(0).children().eq(0).remove();
				element.removeClass(before);
				element.addClass(after);
				element.attr("src", imgString);
				element.attr("title", altString);
				element.attr("alt", altString);
			}
		},
		error: e => {
			console.log(e);
		}
	});
}

$(document).ready(function () {
	$("#notifStart div div.notificationRight div.notifBtns input.markAsReadBtn").click(function () {
		var toUpdate = $(this).parent().parent().parent();
		var ok = confirm("¿Estas seguro?");
		if (ok)
			manageNotif('mark', $(this), toUpdate);
	});

	$("#notifStart div div.notificationRight div.notifBtns input.markAsNotReadBtn").click(function () {
		var toUpdate = $(this).parent().parent().parent();
		var ok = confirm("¿Estas seguro?");
		if (ok)
			manageNotif('mark', $(this), toUpdate);
	});

	$("#notifStart div div.notificationRight div.notifBtns input.deleteNotifBtn").click(function () {
		var toDelete = $(this).parent().parent().parent();
		var ok = confirm("¿Estas seguro?");
		if (ok)
			manageNotif('delete', $(this), toDelete);
	});
});