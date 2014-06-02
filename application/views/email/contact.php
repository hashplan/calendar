<div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Contact us</h3>
			<?php echo validation_errors('<p class = "form_error">');?>
	</div>
<div class = "modal-body">
		<?php echo form_open('email/contact'); ?>
			<form class="col-md-12">
				<input type="text" name = "user_name" id = "user_name" value="<?php echo set_value('user_name'); ?>" class="form-control" placeholder="Name">
			</form>
			<br>
			<div class = "row">
				<form class="col-md-12">
					<input type="text" name = "user_email" id = "user_email" value="<?php echo set_value('user_email'); ?>" class="form-control" placeholder="Email">
				</form>
			</div>
			<br>
			<div class = "row">
				<form class = "col-md-12">
					<textarea class="form-control" name = "contact_description" id = "contact_description" rows="3" value="<?php echo set_value('contact_description'); ?>" placeholder="What is troubling you?"></textarea>
				</form>
			</div>
			<br>
			<p><?php echo form_submit('submit', 'Submit','class = "btn btn-primary btn-sm"');?>
			</p>
		<?php echo form_close();?>