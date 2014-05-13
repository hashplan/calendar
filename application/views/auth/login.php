<div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
		  <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3><?php echo lang('login_heading');?></h3>
			<!--<p><?php echo lang('login_subheading');?></p>
			<p>Please login using your email and password.</p>-->

			<div id="infoMessage"><?php echo $message;?></div>
	</div>
<div class = "modal-body">
		<?php echo form_open("auth/login");?>

			<div class = "row">
				<div class = "col-md-3">
					<p><strong>Email:</strong></p><!--<?php echo lang('login_identity_label', 'identity');?>-->
								
						
				</div>
				<div class = "col-md-4">
					<?php echo form_input($identity);?>
				</div>
			</div>
		  
		  <div class = "row">
			<div class = "col-md-3">
				<?php echo lang('login_password_label', 'password');?>
			</div>
			<div class = "col-md-4">
				<?php echo form_input($password);?>
			</div>
		  </div>
			<hr>
		  <p>
			<?php echo lang('login_remember_label', 'remember');?>
			<?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
		  </p>

		  <p><?php echo form_submit('submit', 'Login','class = "btn btn-primary btn-sm"');?>
		  <?php echo anchor(site_url(),"Cancel",'class = "btn btn-default btn-sm"');?></p>

		<?php echo form_close();?>

<p><a href="auth/forgot_password"><?php echo lang('login_forgot_password');?></a></p>