<div class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo site_url('user/dashboard'); ?>"><img src="<?php echo site_url('/assets/img/logo/hashplan_150-28.png');?>" alt="Hashplan logo"></a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li><?php echo anchor('user/dashboard/', "Profile");?></li>
				<li><?php echo anchor('user/dashboard/all', 'Events'); ?></li>
				<li><a href="<?php echo site_url('user/dashboard/friends/'.$user->id); ?>">Friends</a></li>
				<li><?php echo anchor('user/dashboard/invites/'.$user->id,'Invites');?></li>
			</ul>

			<!--Side bar-->
			<ul class="nav navbar-nav navbar-right">
				<li><?php echo anchor('user/dashboard','Event Hosting');?></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user">&nbsp </span><?php echo (string)$user->first_name;?><b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><?php echo anchor('user/account_settings','<span class="glyphicon glyphicon-tasks">&nbsp </span>Account');?></li>
						<li class="divider"></li>
						<li><?php echo anchor('auth/logout','<span class="glyphicon glyphicon-log-out">&nbsp </span>Logout');?></li>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>

<div class = "container">
	<div class="row">

		<div class="col-md-2">
			<div class = "thumbnail">
				<img src="<?php echo site_url('/assets/img/users/Stas.jpg');?>", alt="Stas image" class = "img-responsive img-rounded">
			</div>
			<hr>
			<!-- Single button -->
			<?php echo anchor('user/dashboard/user_added_event',"ADD EVENT",'class = "btn btn-primary btn-block" data-toggle = "modal" data-target = "#user_added_event_form"');?>
			<?php echo anchor('user/dashboard/favourite',"<span class='glyphicon glyphicon-thumbs-up'> &nbsp</span>Favourites",'class = "btn btn-default btn-block button-favourites"');?>
			<?php echo anchor('user/dashboard/trash',"<span class='glyphicon glyphicon-trash'> &nbsp</span>Trash",'class = "btn btn-default btn-block button-trash"');?>
		</div>

		<div class="col-md-8">
			<?php $this->load->view($view, $data) ?>
		</div>

		<div class = "col-md-2">
			<h4>Events of Interest</h4>
			<div>
				<div style="background-color: gray">place holders</div>
				<div style="background-color: lightblue">place holders</div>
				<div style="background-color: darkblue">place holders</div>
				<!--<?php if(isset($cal)): echo $cal; endif;?>-->
			</div>
		</div>

	</div>
</div>

<!--modal for event details-->
<!-- Modal -->
<div class="modal" id="event_modal" tabindex="-1" role="dialog" aria-labelledby="event_modal" aria-hidden="true">
</div>
<!--modal for event per metro-->
<!-- Modal -->
<div class="modal" id="event_cities" tabindex="-1" role="dialog" aria-labelledby="event_cities" aria-hidden="true">
</div>
<!--modal for private event form-->
<!-- Modal -->
<div class="modal" id="user_added_event_form" tabindex="-1" role="dialog" aria-labelledby="user_added_event_form" aria-hidden="true">
</div>
<!--modal for contact form-->
<!-- Modal -->
<div class="modal" id="contact_form" tabindex="-1" role="dialog" aria-labelledby="contact_form" aria-hidden="true">
</div>