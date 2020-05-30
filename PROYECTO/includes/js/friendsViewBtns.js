function searchUser(username) {
	var data = {
		"searchVal": username,
		"filter" : "username"
	}
	$.ajax({
		type: "POST",
		dataType: "json",
		url: "includes/searchUser.php",
		data: data,
		success: data => {
			if (data.length == 0) {
				var newList = $('<div class="searchList tarjeta_blanca"><p>Este usuario no existe.</p></div>');
				$("#searchUser").append(newList);
			}
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
		var username = $("#searchUserInput").val().replace(/<\/?[^>]+(>|$)/g, "");
        $("#searchUser div.err").remove();
        var errMessage = isValidUsername(username);
        if (errMessage == '') {
            searchUser(username);
        }
        else {
            var errDiv = $('<div class="err tarjeta_blanca"><p>' + errMessage + '</p></div>');
            $("#searchUser").append(errDiv);
        }
    });
});