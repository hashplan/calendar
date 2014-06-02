<div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>ADD AN EVENT</h3>
			<?php echo validation_errors('<p class = "form_error">');?>
	</div>
<div class = "modal-body">
		<?php echo form_open('user/dashboard/user_added_event'); ?>
			<form class="col-md-12">
				<input type="text" name = "user_added_event_name" id = "user_added_event_name" value="<?php echo set_value('user_added_event_name'); ?>" class="form-control" placeholder="Event Name">
			</form>
			<br>
			<div class = "row">
				<form class="col-md-12">
					<input type="text" name = "user_added_event_address" id = "user_added_event_address" value="<?php echo set_value('user_added_event_address'); ?>" class="form-control" placeholder="Address">
				</form>
			</div>
			<br>
			<div class = "row">
				<form class="col-md-12">
					<input type="text" name = "user_added_event_location" id = "user_added_event_location" value="<?php echo set_value('user_added_event_location'); ?>"class="form-control" placeholder="Location">
				</form>
			</div>	
			<br>
			<div class = "row">
			
			<div class="col-md-4">
				<input type="hidden" name="user_added_event_date"/>
				<label for="user_added_event_date">Choose Date</label>
				<input type="text" class="form-control" id="user_added_event_date"/>
			</div>
			
				<div class = "col-md-4">
					<input type="hidden" name="user_added_event_time"/>
					<label for="user_added_event_time">Choose Time</label>
					<button type="button" class="btn btn-default dropdown-toggle" id="user_added_event_time" data-toggle="dropdown">HH:MM<span class="caret"></span></button>
					<ul class="dropdown-menu" role="menu">
						<div class="NEED TO GET TIME"></div>
					</ul>
				</div>
			</div>
			<br>
			<div class = "row">
				<form class = "col-md-12">
					<textarea class="form-control" name = "user_added_event_description" id = "user_added_event_description" rows="3" value="<?php echo set_value('user_added_event_description'); ?>" placeholder="Description"></textarea>
				</form>
			</div>
			<br>
			<p><?php echo form_submit('submit', 'Save','class = "btn btn-primary btn-sm"');?>
			</p>

		<?php echo form_close();?>