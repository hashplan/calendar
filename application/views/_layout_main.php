<?php $this->load->view('components/page_head');?>
<!--<h1> <?php echo anchor('',strtoupper(config_item('site_name'))); ?> Search, Schedule, Share, Enjoy</h1>-->
<div class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class = "container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
		  <a class="navbar-brand" href="<?php echo site_url(''); ?>"><img src="<?php echo site_url('/assets/img/logo/hashplan_150-28.png');?>" alt="Hashplan logo"></a>
		</div>
		<div class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				  <li><?php echo anchor('','Home'); ?></li>
				  <li><a href="<?php echo site_url('page/about'); ?>">About</a></li>
			</ul>
	  
	   <ul class="nav navbar-nav navbar-right">
			  <li><?php echo anchor('auth/login','Login <span class="glyphicon glyphicon-log-in">&nbsp </span>', 'data-toggle="modal" data-target="#login_modal"');?></li>
			  <!--<li> &nbsp </li>
			  <li><?php echo anchor('auth/create_user','Signup <span class="glyphicon glyphicon-pencil">&nbsp </span>', 'data-toggle="modal" data-target="#create_user_modal"');?></li>
-->
		</ul>
		</div>
	</div>
</div>
<br>
<br>
<br>
<div class = "container">
	<div class = "row">
	<!--Main column-->
		<div class = "col-md-12">
				<?php $this->load->view($subview);?>
		</div>	
	</div>
</div>

<!--modal for login-->
<!-- Modal -->
<div class="modal" id="login_modal" tabindex="-1" role="dialog" aria-labelledby="login_modal" aria-hidden="true">
</div>

<!--modal for create user-->
<!-- Modal -->
<div class="modal" id="create_user_modal" tabindex="-1" role="dialog" aria-labelledby="create_user_modal" aria-hidden="true">
</div>
 <?php $this->load->view('components/page_tail');?>