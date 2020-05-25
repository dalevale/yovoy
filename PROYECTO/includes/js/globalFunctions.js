function formatDate(d) {
	var date = new Date(d);
	var yr = date.getFullYear();
	var month = date.getMonth() > 8 ? (date.getMonth() + 1) : '0' + (date.getMonth() + 1);
	var day = date.getDate() < 10 ? '0' + date.getDate() : date.getDate();
	var newDate = yr + '-' + month + '-' + day;
	return newDate;
}

function formatDateWithTime(d) {
	var date = formatDate(d)
	var hours = d.getHours() > 12 ? d.getHours() - 12 : d.getHours();
	var time = hours + ':' + d.getMinutes();
	var str = d.getHours() > 12 ? 'pm' : 'am';
	var datetime = date + ' ' + time + str;

	return datetime;
}