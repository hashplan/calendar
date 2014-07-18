<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <!--<h3><?php echo lang('create_user_heading'); ?></h3>-->
            <p><strong><?php echo lang('create_user_subheading'); ?></strong></p>

            <div id="infoMessage"><?php echo $message; ?></div>
        </div>
        <div class="modal-body">
            <?php echo form_open("auth/create_user"); ?>

            <div class="row">
                <div class="col-md-4">
                    <p><strong>First:</strong></p>
                </div>
                <div class="col-md-6">
                    <?php echo form_input($first_name); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <p><strong>Last:</strong></p>
                </div>
                <div class="col-md-6">
                    <?php echo form_input($last_name); ?>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-md-4">
                    <p><strong>Email:</strong></p>
                </div>
                <div class="col-md-6">
                    <?php echo form_input($email); ?>
                </div>
            </div>
            <!--
		<div class = "row">
			<div class = "col-md-3">
					<?php echo lang('create_user_company_label', 'company'); ?>
			 </div>
			<div class = "col-md-6">
					<?php echo form_input($company); ?>
			 </div>
		</div>

		<div class = "row">
			<div class = "col-md-3">
					<?php echo lang('create_user_phone_label', 'phone'); ?>
			 </div>
			 <div class = "col-md-6">
					<?php echo form_input($phone); ?>
			  </div>
		</div>
		-->
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Password:</strong></p>
                </div>
                <div class="col-md-6">
                    <?php echo form_input($password); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <p><strong>Confirm:</strong></p>
                </div>
                <div class="col-md-6">
                    <?php echo form_input($password_confirm); ?>
                </div>
            </div>
            <br>

            <div class="col-md-12">
                <a href="<?php echo site_url('Facebook_ion_auth/login'); ?>"><img class="img-responsive"
                                                                                  src="<?php echo site_url('/assets/img/logo/facebooksignup.png'); ?>"
                                                                                  alt="Facebook sign up"></a>
            </div>
            <div class="col-md-12">
                <p>By clicking Sign up, you agree to the User Agreement</p>
            </div>
            <div class="row">
                <div class="col-md-5">
                </div>
                <div class="col-md-7">
                    <?php echo form_submit('submit', 'Sign up', 'class = "btn btn-primary btn-sm"'); ?>
                    <?php echo anchor(site_url(), "Cancel", 'class = "btn btn-default btn-sm"'); ?>
                </div>
            </div>
<?php echo form_close(); ?>