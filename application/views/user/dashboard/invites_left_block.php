<button type="button" class="btn btn-primary btn-block">Invite friends</button>
<div class="panel panel-default">
	<div class="panel-heading">Inbox</div>
</div>
<ul>
	<li><?php echo anchor('user/friends/invites', 'Friends') ?></li>
	<li><?php echo anchor('user/friends/invites/events', 'Events') ?></li>
	<li><?php echo anchor('user/friends/invites/sent', 'Sent') ?></li>
</ul>
<?php echo anchor('user/events/trash',"<span class='glyphicon glyphicon-trash'> &nbsp</span>Trash",'class = "btn btn-default btn-block button-trash"');?>