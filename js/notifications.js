/*!
 * rockEnroll Notifications v1.0
 * (c) 2015 Yngve Sundfjord
 */

var base_url = 'http://localhost/rockEnroll';

$(document).ready(function() {
	getNotifications();
	function getNotifications() {
		$.ajax({
		type: 'POST',
		url: base_url+'/index.php/notification/getNotifications',
		dataType: 'json',
		cache: false,
		global: false,
		success:
			function(data) {
				var count = $('.notifications li').length;
				$.each(data, function(i, item) {
					var count = 0;
					if ($('#n'+item.id).length == 0) {
    					$('.notifications').append('<li class="notification" id="n'+item.id+'">'+item.message+'</li>');
    					count++;
					}
				});
				var newCount = $('.notifications li').length;
				if(count != newCount) {
					var newTotal = parseInt(newCount)-parseInt(count);
					// Uncomment when more finishedd
					//$('.badge').text(newTotal);
				} else {
					// Uncomment when more finished
					//$('.badge').text(count);
				}
			}
		});
	}

	setInterval(getNotifications, 10000);

	$('#notifications').click(function() {
		/*if (!$('#notificationsFlyOut').is(':visible')) {
			getNotifications();
		}*/
		$('#notificationsFlyOut').toggle();
		$('.badge').text('');
	});
});