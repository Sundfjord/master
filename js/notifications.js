/*!
 * rockEnroll Notifications v1.0
 * (c) 2015 Yngve Sundfjord
 */

var base_url = 'http://localhost/rockEnroll';
var title = document.title;

$(document).ready(function() {
	$('.timeago').each(function(i, item) {
		var created = moment($(this).text()).fromNow();
		$(this).text('');
		$(this).append('<span class="glyphicon glyphicon-time"></span>'+created);
	});

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
						if ($('.notification').length > 4) {
							// Remove oldest item if we approach limit
							$('.notification').last().remove();
						}
    					$('.notifications').prepend('<li class="notification" id="n'+item.id+'" style="background-color: #e7f3ff;"><button type="button" class="seen btn btn-success btn-xs" style="float: right;">Got it</button><a class="block" href="'+base_url+'/index.php/team/'+item.team_id+'"><div class="message">'+item.message+'</div><div class="timestamp small"><span class="glyphicon glyphicon-time"></span>'+timestamp+'</div></a></li>');
    					count++;
					}
				});
				var newCount = $('.notifications li').length;
				if(count != newCount) {
					var newTotal = parseInt(newCount)-parseInt(count);
					// Uncomment when more finishedd
					if (newTotal != 0) {
						$('.badge').text(newTotal);
						document.title = '('+newTotal+') '+title;
					}
				} else {
					// Uncomment when more finished
					if (count != 0) {
						$('.badge').text(count);
						document.title = '('+count+') '+title;
					}
				}
			}
		});
	}
	setInterval(getNotifications, 30000);

	$(document).on('click', '.seen' , function() {
		var li = $(this).closest('li');
		var id = li.attr('id').substr(1);
		markAsRead(id)
	});

	function markAsRead(id) {
		var button = $('#n'+id).find($('.seen'));
		// Set a loader image inside the button
		//
		$.ajax({
			type: 'POST',
			url: base_url+'/index.php/notification/markNotificationAsRead/'+id,
			//dataType: 'text',
			cache: false,
			global: false,
			timeout: 2000,
			success:
				function(data) {
					if (data) {
						$('#n'+id).css('background-color', '');
						// Either remove or change text to something
						// button.remove();
					}
				}
		});
	}
	// Hides notifications if click anywhere else
	$(document).mouseup(function(event) {
		var div = $('#notificationsFlyOut');
		var alreadyDone = false;
		if (event.target.id == 'notifications') {
			if (!$('#notificationsFlyOut').is(':visible')) {
				$('#notificationsFlyOut').show();
				$('.badge').text('');
				document.title = title;
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