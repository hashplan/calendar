<?php $this->load->view('/components/page_head');?>
  <body>
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class = "container-fluid">
	  <div class="navbar-header">
			<a class="navbar-brand" href="<?php echo site_url('user/dashboard'); ?>"><img src="<?php echo site_url('/assets/img/logo/logo.png');?>" alt="Hashplan logo"></a>
			<ul class="nav navbar-nav">
				  <li><?php echo anchor('user/dashboard','All Events'); ?></li>
				  <li><?php echo anchor('user/dashboard/my_plan/'.$user->id,"My #");?></li>
				  <li><?php echo anchor('user/dashboard/social_view/'.$user->id,'Social View'); ?></li>
				  <li><a href="<?php echo site_url('user/dashboard/friends/'.$user->id); ?>">Friends</a></li>
				  <li><?php echo anchor('user/dashboard/invites/'.$user->id,'Invites');?></li>
				  <li><?php echo anchor('user/dashboard/groups/'.$user->id,'Groups');?></li>
			</ul>
	  </div>
	  <!--Side bar-->
		<ul class="nav navbar-nav navbar-right">
		  <li class="dropdown">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user">&nbsp </span><?php echo (string)$user->first_name;?><b class="caret"></b></a>
			<ul class="dropdown-menu">
				<li><?php echo anchor('user/profile','<span class="glyphicon glyphicon-tasks">&nbsp </span>Profile');?></li>
				<li><?php echo anchor('user/dashboard','<span class="glyphicon glyphicon-link">&nbsp </span>Some other link');?></li>
				<li class="divider"></li>
				<li><?php echo anchor('auth/logout','<span class="glyphicon glyphicon-log-out">&nbsp </span>Logout');?></li>
			</ul> 
		  </li>
			 <li><a href="#">Another action</a></li>
		</ul>
	</div>
</div>
<br>
<br>
<br>
<div class = "container">
	<div class = "row">
	<!--Main column-->
		<div class = "col-md-9">
				<?php $this->load->view($subview);?>
		</div>	
	</div>
</div>
 <?php $this->load->view('/components/page_tail');?>