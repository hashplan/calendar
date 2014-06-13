<?php foreach($friends as $friend) {?>
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="left-section">
				<div class="friend-pic"><img src="/assets/img/icons/no-image-100.png"/></div>
			</div>
			<div class="right-section">
				<div class="friend-name"><?php echo anchor('user/events/'. $friend->id, $friend->name) ?></div>
				<div class="friend-mutual-count"><?php echo html_escape($friend->mutual_friends_count) ?> shared connections</div>
				<?php echo anchor('user/events/'. $friend->id, 'View plans', array('class' => 'btn btn-primary friend-view-plans-button')) ?>
			</div>
		</div>
	</div>
<?php } ?>