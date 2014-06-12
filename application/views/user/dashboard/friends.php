<div class="container">
	<div class="row">
		<div class="col-md-6 col-md-offset-3">
			<h2><?php echo html_escape($page_title) ?></h2>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3"></div>

		<div class="col-md-6">
			<div class="row">
				<div class="col-md-12">
					<input type="text" placeholder="Search" class="form-control" id="friends-name"/>
					<a href="#" class="friends-advanced-search">Advanced search</a>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">Friends</div>
					</div>
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
				</div>
			</div>
		</div>

		<div class="col-md-3 people-you-may-know">
			<div class="panel panel-default">
				<div class="panel-heading">People you may know</div>
			</div>

			<?php foreach($people_you_may_know as $dude) { ?>
				<div class="row">
					<div class="col-md-12">
						<div class="left-section">
							<div class="dude-pic"><img src="/assets/img/icons/no-image-100.png"/></div>
						</div>
						<div class="right-section">
							<div class="dude-name">
								<?php echo html_escape($dude->name) ?>
							</div>
						</div>
						<a href="#"><i class="glyphicon glyphicon-remove"></i></a>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>