<div class="jumbotron" style = "background-image: url('../assets/img/homepage/Beer Garden with Boat.jpg');">	
	<p><?=sprintf(lang('email_activate_subheading'), anchor('activate/'. $id .'/'. $activation, 'Activate Account', 'class="btn btn-lg btn-success"'); ?></p>
</div>
<div class="row">
	<div class = "col-md-12" style="background-color:#f5f5f5">
	<img src="<?php echo site_url('/assets/img/logo/hashplan.jpg');?>" class = "img-responsive" style = "height:30px" alt="Hashplan logo">
		<h3>Dear <?php echo sprintf(lang('email_activate_heading'), $identity);?>,
		</h3>
		<h3>Welcome to Hashplan! 
		</h3>
			<br>
		<h3>Hashplan was built for people like you who are looking for great events in their area.
			We track thousands of concerts, festivals, sporting events, and more across the U.S.
			<br>
			Start making plans today and sharing them with friends! Click the button above to activate your account!
		</h3>
	</div>
</div>