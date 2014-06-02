<div class = "container">
		<div class="col-md-2">
			<div class = "thumbnail">
			  <img src="<?php echo site_url('/assets/img/users/Stas.jpg');?>", alt="Stas image">
			</div>
		<hr>
        </div>
      <div class = "col-md-8">
			<h4>Welcome <span class="text-muted"><?php echo (string)$user->first_name." " .(string)$user->last_name;?></span></h4>
			<h5>Here are your profile details:</h5>
				<div class = "row">
					<div class = "col-md-3">	
					</div>
				</div>
			<hr>					
				<div class = "col-md-12">
					<ul class="nav nav-tabs">
						<li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
						<li><a href="#teams" data-toggle="tab">Teams</a></li>
						<li><a href="#favorites" data-toggle="tab">Favorites</a></li>
						<li><a href="#other_calendars" data-toggle="tab">Other Calendars</a></li>
					</ul>
					<div id='content' class="tab-content">
					  <div class="tab-pane active" id="settings">
						<div class = "row">
							<div class = "col-md-7">
								<br>
								<h4>Change your profile picture:</h4>
								<div id = "user_avatar">
									<?php echo form_open_multipart('user/account_settings/avatar_upload/'.$user->id);
									echo form_upload('userfile');
									echo form_submit('upload','Upload');
									echo form_close();
									?>
								</div>
							</div>
						</div>
						<hr>
							<div class = "row">
								<div class = "col-md-6" style = "background-color: yellow">
									<address>
										<br>
										City, State ZIP<br>
									</address>
								</div>
								<div class = "col-md-6" style = "background-color: #F8F8F8">
								<p>Action 1</p>
								<p>Action 2</p>
								</div>
							</div>
					  </div>
					  <div class="tab-pane" id="teams">
						<div class = "row">
							<div class="col-md-2">
									<h2>Football</h2>
									<hr>
									<h2>Baseball</h2>
									<hr>
									<h2>Others</h2>
									<hr>
							</div>
						</div>
					  </div>
					  <div class="tab-pane" id="favorites">
						  <div class = "row">
									<div class="col-md-2">
										<h2>Festivals</h2>
										<hr>
										<h2>Nightlife</h2>
										<hr>
										<h2>Bands</h2>
										<hr>
									</div>
						  </div>
					</div>
					   <div class="tab-pane" id="other_calendars">
							<div class = "row">
								<div class="col-md-2">
											<h2>Facebook</h2>
											<hr>
											<h2>Google</h2>
											<hr>
											<h2>Apple</h2>
											<hr>
								</div>
							</div>
					  </div>
					</div>    
				</div>
		</div>
	<div class = "col-md-2" style = "background-color: #F8F8F8">
		<h3>placeholder</h3>
	</div>
</div>