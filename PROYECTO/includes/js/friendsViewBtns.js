function searchUser(username) {
	var data = {
		"username": username
	}
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "includes/searchUser.php",
		data: data,
		success: data => {
			if (data.length == 0)
				alert("Cant delete this comment at the moment.");
			else {
				$("#searchUser div.searchList").remove();
				var newList = $('<div class="searchList tarjeta_blanca"></div>');
				for (var i = 0; i < data.length; i++) {
					var user = data[i];
					var userImgName = user.imgName;
					var userImgDir = "includes/img/users/";
					var userImgPath = userImgDir + userImgName;
					var row = '<a href="profileView.php?profileId=' + user.id + '"><img src = "' + userImgPath + '?random=' + Math.random(0, 100000) + '" alt = "event" height = "50" width = "50" ></a> ' +
						'<a href="profileView.php?profileId=' + user.id + '">' + user.username + '</a>';
					newList.append($(row));
				}
				$("#searchUser").append(newList);
			}
				
		},
		error: e => {
			console.log(e);
		}
	});
}

$(document).ready(function () {
	$("#searchUserBtn").click(function () {
		var username = $("#searchUserInput").val();
        $("#searchUser div.err").remove();
        var errMessage = isValidUsername(username);
        if (errMessage == '') {
            searchUser(username);
        }
        else {
            var errDiv = $('<div class="err"><p>' + errMessage + '</p></div>');
            $("#searchUser").append(errDiv);
        }
    });

});