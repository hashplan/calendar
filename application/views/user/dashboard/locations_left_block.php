<div id="locations-left-block">
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
				<?php foreach($locations as $i => $location) {
					$hidden_class = $i > 2 ? 'location-hidden' : '' ?>
					<li class="<?php echo $hidden_class ?>">
						<input type="checkbox" class="left-block-location" id="left-block-location-<?php echo html_escape($location->id) ?>" value="<?php echo html_escape($location->id) ?>">
						<label for="left-block-location-<?php echo html_escape($location->id) ?>"><?php echo html_escape($location->city) ?></label>
					</li>
				<?php } ?>
			</ul>
			<?php if (count($locations) > 3) { ?>
				<a href="#" class="locations-show-more-link">More</a>
			<?php } ?>
		</div>
	</div>
</div>