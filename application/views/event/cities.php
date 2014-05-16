<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 class="modal-title" id="myModalLabel">Select City</h3>
		</div>
		<div class="modal-body">
			<ul>
				<?php foreach($cities as $city) { ?>
					<li>
						<div class="item-city-id" style="display: none"><?php echo html_escape($city->id) ?></div>
						<a href="#" class="item-city-name" aria-hidden="true"><?php echo html_escape($city->city) ?></a>
						<span>(<?php echo $city->events_count ?>)</span>
					</li>
				<?php } ?>
			</ul>
		</div>
	</div>
</div>