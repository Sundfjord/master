<div id="allNotifications" class="container">
	<h3>Your Notifications</h3>
	<ul id="notificationList">
	<?php foreach ($notifications as $row) { ?>
		<li class="notification<?php echo $row['id']; ?>">
			<a class="block" href="<?php echo base_url(); ?>index.php/team/<?php echo $row['team_id'] ; ?>"><?php echo $row['message']; ?>
			<div class="timeago"><span class="glyphicon glyphicon-time"></span><?php echo $row['created']; ?></div>
			</a>
		</li>
	<?php } ?>
	</ul>
</div>