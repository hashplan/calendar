<div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>ADD AN EVENT</h3>
			<?php echo validation_errors();?>
	</div>
<div class = "modal-body">
		<?php echo form_open('user/dashboard/private_event'); ?>
				<div class = "row">
					<form class="col-md-12">
						<input type="text" id = "private_event_name" class="form-control" placeholder="Event Name">
					</form>
				</div>
				<div class = "row">
					<form class="col-md-12">
						<input type="text" id = "private_event_address" class="form-control" placeholder="Address">
					</form>
				</div>
				<div class = "row">
					<form class="col-md-12">
						<input type="text" id = "private_event_location" class="form-control" placeholder="Location">
					</form>
				</div>
				<div class = "row">
					<div class="col-md-4">
						<input type="hidden" name="private_event_date" id="date-hidden"/>
						<button type="button" class="btn btn-default dropdown-toggle" id="private_event_date" data-toggle="dropdown">Choose Date <span class="caret"></span></button>
						<ul class="dropdown-menu" role="menu">
							<div class="datepicker"></div>
						</ul>
					</div>
					<div class = "col-md-4">
						<input type="hidden" name="private_event_time" id="time-hidden"/>
						<button type="button" class="btn btn-default dropdown-toggle" id="private_event_time" data-toggle="dropdown">Choose Time <span class="caret"></span></button>
						<ul class="dropdown-menu" role="menu">
							<div class="NEED TO GET TIME"></div>
						</ul>
					</div>
				</div>
				<div class = "row">
					<form class = "col-md-12">
						<textarea class="form-control tinymce" id = "private_event_description" rows="3" placeholder="Description"></textarea>
					</form>
				</div>
				<p><?php echo form_submit('submit', 'Save','class = "btn btn-primary btn-sm"');?>
					  <?php echo anchor(site_url('user/dashboard'),"Close",'class = "btn btn-default btn-sm"');?>
				</p>

		<?php echo form_close();?>