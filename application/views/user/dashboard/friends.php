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
					<div id="friends-list">
						<?php echo $friends_list ?>
					</div>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="panel panel-default">
				<div class="panel-heading">People you may know</div>
			</div>

			<div id="people-you-may-know-list">
				<?php echo $people_you_may_know_list ?>
			</div>
		</div>
	</div>
</div>