<?php foreach($people as $dude) {?>
	<div class="panel panel-default">
		<div class="panel-body">
			<div class="left-section">
				<div class="friend-pic"><img src="/assets/img/icons/no-image-100.png"/></div>
			</div>
			<div class="right-section">
				<div class="friend-name"><?php echo anchor('user/events/'. $dude->id, $dude->name) ?></div>
				<div class="friend-mutual-count"><?php echo html_escape($dude->mutual_friends_count) ?> shared connections</div>
				<?php if ($friends_page_type === 'friends') {
					echo anchor('user/events/'. $dude->id, 'View plans', array('class' => 'btn btn-primary friend-view-plans-button'));
				} else if ($friends_page_type === 'add_friends') {
					echo anchor('user/friends/friend_request/'. $dude->id, 'Connect', array('class' => 'btn btn-primary friend-view-plans-button'));
				} ?>
			</div>
		</div>
	</div>
<?php } ?>