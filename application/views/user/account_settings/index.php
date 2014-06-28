<div class = "container">
	<div class="col-md-2">
        <div class = "thumbnail user-avatar">
            <?php if($user->avatar_path){?>
                <img src="<?php echo site_url('/assets/img/users/'.$user->avatar_path);?>", alt="" class = "img-responsive img-rounded">
            <?php }else{ ?>
                <img src="<?php echo site_url('/assets/img/icons/no-image-100.png');?>", alt="" class = "img-responsive img-rounded">
            <?php } ?>
        </div>
		<hr>
	</div>
	<div class = "col-md-8">
		<h2>Welcome <span class="text-muted"><?php echo (string)$user->first_name." " .(string)$user->last_name;?></span></h2>
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
					<?php if (!$form_is_valid) { ?>
						<div class="alert alert-danger">
							<?php echo $validation_errors; ?>
						</div>
					<?php }
					if ($updated && $update_result) { ?>
						<div class="alert alert-success">
							Profile updated successfully
						</div>
					<?php } ?>
					<?php echo form_open(); ?>
					<div class="row">
						<div class="col-md-12">
							<div><?php echo anchor('user/account_settings/choose_metro', 'Change Location:', 'data-toggle="modal" data-target="#event_cities"');?></div>
							<div><h5 id="metro-name"><?php echo html_escape($metro_name) ?></h5></div>
							<input type="hidden" name="metro_id" id="metro-id" value="<?php echo set_value('metro_id', $metro_id) ?>">
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label for="account-user-name">Username</label>
							<input type="text" class="form-control input-sm" id="account-user-name" name="username" value="<?php echo set_value('username', $user->username) ?>">
							<label for="account-first-name">First name</label>
							<input type="text" class="form-control input-sm" id="account-first-name" name="first_name" value="<?php echo set_value('first_name', $user->first_name) ?>">
							<label for="account-last-name">Last name</label>
							<input type="text" class="form-control input-sm" id="account-last-name" name="last_name" value="<?php echo set_value('last_name', $user->last_name) ?>">
						</div>
						<div class="col-md-6">
							<label for="account-password">Password</label>
							<input type="password" class="form-control input-sm" id="account-password" name="password" size="50" />
							<label for="account-password-confirm">Confirm Password</label>
							<input type="password" class="form-control input-sm" id="account-password-confirm" name="password_confirm" size="50" />
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<button type="submit" class="btn btn-primary">Save</button>
						</div>
					</div>
					<?php echo form_close() ?>
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