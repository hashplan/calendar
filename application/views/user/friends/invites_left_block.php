<button type="button" class="btn btn-primary btn-block">Invite friends</button>
<br>
<div class="panel panel-default">
    <div class="panel-heading">Inbox</div>
		<div class="panel-body">
			<ul>
				<li><?php echo anchor('user/friends/invites', 'Friends') ?>
					<span>(<?php echo html_escape($counts['received_friend_requests']) ?>)</span>
				</li>
				<li><?php echo anchor('user/friends/invites/events', 'Events') ?>
					<span>(<?php echo html_escape($counts['received_event_invites']) ?>)</span>
				</li>
				<li><?php echo anchor('user/friends/invites/sent', 'Sent', array("class" => "sent-invites-link", "data-toggle" => "tooltip", "title" => "Includes friend invites and event invites", "data-placement" => "right")) ?>
					<span>(<?php echo html_escape($counts['sent_invites']) ?>)</span>
				</li>
			</ul>
		</div>
</div>
<?php echo anchor('user/events/trash', "<span class='glyphicon glyphicon-trash'> &nbsp</span>Trash", 'class = "btn btn-default btn-block button-trash"'); ?>