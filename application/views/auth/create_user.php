<div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
		<!--<h3><?php echo lang('create_user_heading');?></h3>-->
		<p><?php echo lang('create_user_subheading');?></p>

		<div id="infoMessage"><?php echo $message;?></div>
		</div>
<div class = "modal-body">
		<?php echo form_open("auth/create_user");?>

		<div class = "row">
			  <div class = "col-md-3">
					<p><strong>First:</strong></p>
			   </div>	
			  <div class = "col-md-6">
				<?php echo form_input($first_name);?>
			  </div>
		</div>

		<div class = "row">
			<div class = "col-md-3">
					<p><strong>Last:</strong></p>
			 </div>
			 <div class = "col-md-6">
					<?php echo form_input($last_name);?>
			  </div>
		</div>

		<div class = "row">
			<div class = "col-md-3">
					<p><strong>Email:</strong></p>
			 </div>
			 <div class = "col-md-6">
					<?php echo form_input($email);?>
			  </div>
		</div>
		<!--
		<div class = "row">
			<div class = "col-md-3">
					<?php echo lang('create_user_company_label', 'company');?>
			 </div>
			<div class = "col-md-6">
					<?php echo form_input($company);?>
			 </div>
		</div>

		<div class = "row">
			<div class = "col-md-3">
					<?php echo lang('create_user_phone_label', 'phone');?> 
			 </div>
			 <div class = "col-md-6">
					<?php echo form_input($phone);?>
			  </div>
		</div>
		-->
		<div class = "row">
			<div class = "col-md-3">
					<p><strong>Password:</strong></p>
			 </div>
			<div class = "col-md-6">
					<?php echo form_input($password);?>
			  </div>
		</div>

		<div class = "row">
			<div class = "col-md-3">
					<p><strong>Confirm:</strong></p>
			 </div>
			 <div class = "col-md-6">
					<?php echo form_input($password_confirm);?>
			  </div>
		</div>

      <p><?php echo form_submit('submit', 'Submit','class = "btn btn-success btn-sm"');?>
			<?php echo anchor(site_url(),"Cancel",'class = "btn btn-default btn-sm"');?></p>
		<?php echo form_close();?>
