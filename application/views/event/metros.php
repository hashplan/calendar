<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 class="modal-title" id="myModalLabel">Select City</h3>
		</div>
		<div class="modal-body">
			<div class="row">
				<?php foreach($metros as $metro) { ?>
					<div class="col-md-6">
						<div class="item-city-id" style="display: none"><?php echo html_escape($metro->id) ?></div>
						<a href="#" class="item-city-name" aria-hidden="true"><?php echo html_escape($metro->city) ?></a>
						<span class = "badge"><?php echo $metro->count ?></span>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>