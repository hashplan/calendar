<?php $this->load->view('components/page_head');?>
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
		</div>
	</div>
</div>
<div class="row" style = "background-image: url('../assets/img/homepage/Beer Garden with Boat.jpg'); height: 660px; width: 800px; margin-top: 50px; margin-left: 350px; padding-right: 225px; background-repeat: no-repeat">	
	<div class = "row">
				<?php $this->load->view($subview);?>
	</div>
</div>