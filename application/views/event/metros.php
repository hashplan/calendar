<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 class="modal-title" id="myModalLabel">Select City</h3>
		</div>
		<div class="modal-body">
			<div class="row">
				<?php if (!$hide_events) { ?>
					<div class="col-md-12">
						<div class="item-metro-id" style="display: none">0</div>
						<a href="#" class="item-metro-name" aria-hidden="true">Any</a>
						<span class="badge">all</span>
					</div>
				<?php } ?>
				<?php foreach($metros as $metro) { ?>
					<div class="col-md-4 col-sm-12">
						<div class="item-metro-id" style="display: none"><?php echo html_escape($metro->id) ?></div>
						<a href="#" class="item-metro-name" aria-hidden="true" data-picture_path="<?=site_url('assets/img/metroareas/'. (isset($metro->picture_path) &&!empty($metro->picture_path) ? $metro->picture_path : 'Nashville_Skyline_-_Cropped_Format.jpg'));?>"><?php echo html_escape($metro->city) ?></a>
						<?php if (!$hide_events) { ?>
							<span class = "badge"><?php echo $metro->count ?></span>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>