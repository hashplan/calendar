<form action="<?= site_url('signup') ?>" method="POST" id="signup-form" class="signup-form form-horizontal" role="form">
    <div class="form-group">
        <label for="identity" class="col-md-2 control-label"><strong>First:</strong></label>
        <div class="col-md-10">
            <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name" value="<?=set_value('identity')?>">
        </div>
    </div>
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
</form>