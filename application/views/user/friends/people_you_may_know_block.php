<?php foreach($people_you_may_know as $dude) { ?>
	<div class="row">
		<div class="col-md-12">
			<input type="hidden" class="dude-id" value="<?php echo html_escape($dude->id) ?>"/>
			<div class="left-section">
				<div class="dude-pic"><img src="/assets/img/icons/no-image-100.png"/></div>
			</div>
			<div class="right-section">
				<div class="dude-name">
					<?php echo html_escape($dude->name) ?>
					<br>
					<?php echo anchor('user/friends/friend_request/'. $dude->id, '<i class="glyphicon glyphicon-plus-sign"></i>Connect', array('class' => 'connect-link')) ?>
				</div>
			</div>
			<a href="#" class="remove-from-lists-link"><i class="glyphicon glyphicon-remove"></i></a>
		</div>
	</div>
<?php } ?>