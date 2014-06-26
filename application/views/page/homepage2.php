<!--Main column-->

<!-- Carousel
	================================================== -->
<div id="homepage-slider" class="carousel slide" data-ride="carousel">
	<!-- Indicators -->
	<ol class="carousel-indicators">
		<li data-target="#homepage-slider" data-slide-to="0" class="active black"></li>
		<li data-target="#homepage-slider" data-slide-to="1"></li>
		<li data-target="#homepage-slider" data-slide-to="2"></li>
	</ol>
	<div class="carousel-inner">
		<div class="item active">
			<img src="<?php echo site_url('/assets/img/homepage/crowd for homepage.jpg');?>" alt="Hashplan crowd!">
			<div class="container">
				<div class="carousel-caption">
					<div class="homepage_timer">
						<div class = "col-md-12">
							<h1>It is <span id = "homepage_timer"></span>, what are you going to do?</h1>
									<h3>Make plans and share them with friends!</h3>
						</div>
					</div>
					<div class = "col-md-12">
						<?php echo anchor('auth/create_user','Signup! <span class="glyphicon glyphicon-pencil">&nbsp </span>', 'class="btn btn-md btn-success"');?>
					</div>
				</div>
			</div>
		</div>
		<div class="item">
			<img src="<?php echo site_url('/assets/img/homepage/baseball game2.jpg');?>" alt="Baseball game!">
			<div class="container">
				<div class="carousel-caption">
				<div class = "col-md-12">
					<h3>Plan It!  Track your plans and share with friends!</h3>
					<p></p>
				</div>
					<div class = "col-md-12">
						<?php echo anchor('auth/create_user','Signup! <span class="glyphicon glyphicon-pencil">&nbsp </span>', 'class="btn btn-md btn-success"');?>
					</div>
				</div>
			</div>
		</div>
		<div class="item">
			<img src="<?php echo site_url('/assets/img/homepage/Beer Garden with Boat2.jpg');?>" alt="Beer garden outside!">
			<div class="container">
				<div class="carousel-caption">
				<div class = "col-md-12">
					<h4>Only a few hours from Happy Hour!</h4>
					<p></p>
				</div>
					<div class = "col-md-12">
						<?php echo anchor('auth/create_user','Signup! <span class="glyphicon glyphicon-pencil">&nbsp </span>', 'class="btn btn-md btn-success"');?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<a class="left carousel-control" href="#homepage-slider" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
	<a class="right carousel-control" href="#homepage-slider" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
</div><!-- /.carousel -->
<!-- START THE FEATURETTES -->
<hr class="featurette-divider">
<div class="row featurette">
	<!--<div class = "col-md-6">
		<h2 class = "featurette-heading">How this works?<span class = "text-muted"> It'll blow your mind!</span></h2>
		<p class="lead">Very easy!</p>
	</div>
	-->
	<div class = "col-md-6">
		<h2 class = "text-muted">How it works?</h2>
	</div>
	<div class = "col-md-12">
		<img class = "featurette-image img-responsive" src="<?php echo site_url('/assets/img/howitworks/how it works on homepage.jpg');?>" alt="How it works!">
	</div>
</div>

<hr class="featurette-divider">
<div class="row featurette">
	<div class = "col-md-6">
		<h2 class = "text-muted">Cool integration!</h2>
	</div>
	<div class = "col-md-12" style = "margin-left:150px">
		<img class = "featurette-image img-responsive" src="<?php echo site_url('/assets/img/homepage/integration.png');?>" alt="Google maps and Yelp integration!">
	</div>
	<!--<div class = "col-md-6">
		<h2 class = "featurette-heading">Integration!<span class = "text-muted"> Check it out!</span></h2>
		<p class="lead">We integrate with maps and APIs to make your life easier.</p>
	</div>
	-->
</div>

<hr class="featurette-divider">
<div class="row featurette">
	<!--<div class = "col-md-6">
		<h2 class = "featurette-heading">What would you like to do?<span class = "text-muted"> Soon you will be able to sign up and find it!</span></h2>
		<p class="lead">A lot of cool things to do. Start searching, scheduling, sharing and enjoying!</p>
	</div>
	-->
	<div class = "col-md-6">
		<h2 class = "text-muted">Go Mobile</h2>
	</div>
	<div class = "col-md-12" style = "margin-left:150px">
		<img class = "featurette-image img-responsive img-rounded" src="<?php echo site_url('/assets/img/homepage/gomobile.png');?>" alt="Mobile app">
	</div>
</div>
<hr>
<div class="container">
	<!--row of columns -->
	<div class="row">
		<div class="col-md-3">
			<h2>Search</h2>
			<p>MANY <span class = "text-muted">cool events</span></p>
			<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
		</div>
		<div class="col-md-3">
			<h2>Go Mobile!</h2>
			<p>Coming soon! The Hashplan app for Android and iPhone</p>
			<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
		</div>
		<div class="col-md-3">
			<h2>Share plans with friends!</h2>
			<p>Find things to do with your friends and start planning today</p>
			<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
		</div>
		<div class="col-md-3">
			<h2>Explore!</h2>
			<p>Browse our listings of thousands of events to discover new activities, venues, musicians, festivals, local artists, and more</p>
			<p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
		</div>
	</div>
</div>