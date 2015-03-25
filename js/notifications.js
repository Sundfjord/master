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
					var timestamp = moment(item.created).fromNow();
					var count = 0;
					// We check if the notification has already been pushed
					if ($('#n'+item.id).length == 0) {
    					$('.notifications').prepend('<li class="notification" id="n'+item.id+'"><a class="block" href="'+base_url+'/index.php/team/'+item.team_id+'"><div class="message">'+item.message+'</div><div class="timestamp small"><span class="glyphicon glyphicon-time"></span>'+timestamp+'</div></a></li>');
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
	setInterval(getNotifications, 30000);

	// Hides notifications if click anywhere else
	$(document).mouseup(function(event) {
		var div = $('#notificationsFlyOut');
		var alreadyDone = false;
		if (event.target.id == 'notifications') {
			if (!$('#notificationsFlyOut').is(':visible')) {
				$('#notificationsFlyOut').show();
				changeColor('show');
				alreadyDone = true;
			}
		}
	    if (!div.is(event.target) && div.has(event.target).length === 0) {
	        if($(div).is(":visible") && !alreadyDone) {
	            $(div).hide();
	            changeColor('hide');
	        }
	    }
	});
	function changeColor(type) {
		if (type == 'show') {
			$('#notifications').css('color', '#000');
		} else {
			$('#notifications').css('color', '#fff');
			$('#notifications').hover(function() {
				$(this).css('color', '#e7e7e7');
			}, function() {
				$(this).css('color', '');
			})
		}
	}
});