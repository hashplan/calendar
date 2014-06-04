<!--Main column-->
<div class="jumbotron homepage_timer">
	<div class = "container col-md-8 col-md-offset-3">
		<p>It is <span id = "homepage_timer"></span>, what are you going to do?</p>
	</div>
</div>
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
					<h4>We are coming soon!</h4>
					<p></p>
					<!--<p><a class="btn btn-sm btn-primary" href="#" role="button">Do it now!</a></p>-->
				</div>
			</div>
		</div>
		<div class="item">
			<img src="<?php echo site_url('/assets/img/logo/plan.png');?>" alt="How it works!">
			<div class="container">
				<div class="carousel-caption">
					<h4>We will be live in a jiffy!</h4>
					<p></p>
					<!--<p><a class="btn btn-sm btn-primary responsive" href="#" role="button">Learn more</a></p>-->
				</div>
			</div>
		</div>
		<div class="item">
			<img src="<?php echo site_url('/assets/img/logo/plan.png');?>" alt="Get started!">
			<div class="container">
				<div class="carousel-caption">
					<h4>Just a bit longer!</h4>
					<p></p>
					<!--<p><a class="btn btn-sm btn-primary" href="#" role="button">Get Started!</a></p>-->
				</div>
			</div>
		</div>
	</div>
	<a class="left carousel-control" href="#homepage-slider" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
	<a class="right carousel-control" href="#homepage-slider" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
</div><!-- /.carousel -->
<!-- START THE FEATURETTES -->
<hr class="featurette-divider">
<div class="row featurette" style="margin-left: 350px">
	<!--<div class = "col-md-6">
		<h2 class = "featurette-heading">How this works?<span class = "text-muted"> It'll blow your mind!</span></h2>
		<p class="lead">Very easy!</p>
	</div>
	-->
	<div class = "col-md-6">
		<img class = "featurette-image img-responsive" src="<?php echo site_url('/assets/img/howitworks/howitworks3.png');?>" alt="How it works!">
	</div>
</div>

<hr class="featurette-divider">
<div class="row featurette" style = "margin-left:350px">
	<div class = "col-md-6">
		<img class = "featurette-image img-responsive" src="<?php echo site_url('/assets/img/homepage/integration.png');?>" alt="Google maps and Yelp integration!">
	</div>
	<!--<div class = "col-md-6">
		<h2 class = "featurette-heading">Integration!<span class = "text-muted"> Check it out!</span></h2>
		<p class="lead">We integrate with maps and APIs to make your life easier.</p>
	</div>
	-->
</div>

<hr class="featurette-divider">
<div class="row featurette" style = "margin-left: 350px">
	<!--<div class = "col-md-6">
		<h2 class = "featurette-heading">What would you like to do?<span class = "text-muted"> Soon you will be able to sign up and find it!</span></h2>
		<p class="lead">A lot of cool things to do. Start searching, scheduling, sharing and enjoying!</p>
	</div>
	-->
	<div class = "col-md-6">
		<img class = "featurette-image img-responsive img-rounded" src="<?php echo site_url('/assets/img/homepage/gomobile.png');?>" alt="Mobile">
	</div>
</div>