/*!
 * rockEnroll Notifications v1.0
 * (c) 2015 Yngve Sundfjord
 */

var base_url = 'http://localhost/rockEnroll';

$(document).ready(function() {
	function getNotifications() {
		$.ajax({
		type: 'POST',
		url: base_url+'/index.php/notification/getNotifications',
		dataType: 'json',
		cache: false,
		success:
			function(data) {
				console.log(data);
			}
		})
	}

	setInterval(getNotifications, 60000)
;});