<div id="locations-left-block" data-user_id="<?php echo $user_id;?>">
	<div class="panel panel-default">
		<div class="panel-heading">
			<div class="panel-title">Location</div>
		</div>
		<div class="panel-body">
			<ul>
				<li>
					<input type="checkbox" class="left-block-location" id="left-block-location-all" value="all">
					<label for="left-block-location-all">All</label>
				</li>
				<?php foreach($locations as $i => $location) { ?>
					<li>
						<input type="checkbox" class="left-block-location" id="left-block-location-<?php echo html_escape($location->id) ?>" value="<?php echo html_escape($location->id) ?>">
						<label for="left-block-location-<?php echo html_escape($location->id) ?>"><?php echo html_escape($location->city) ?></label>
					</li>
				<?php } ?>
			</ul>
			<input type="text" placeholder="Enter the location name" class="form-control" id="locations-enter-name-field" autocomplete="off">
		</div>
	</div>
</div>