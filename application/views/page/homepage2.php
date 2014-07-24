<!--Main column-->

<!-- Carousel
	================================================== -->
<div id="homepage-slider" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators hidden-xs hidden-sm">
        <li data-target="#homepage-slider" data-slide-to="0" class="active black"></li>
        <li data-target="#homepage-slider" data-slide-to="1"></li>
        <li data-target="#homepage-slider" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
        <div class="item active">
            <div class="container">
                <div class="carousel-caption">
                    <h3>CONCERTS, SPORTING EVENTS, FESTIVALS & MORE</h3>
                    <h4>Hashplan connects you and your friends through local events</h4>

                    <p><?=anchor('signup', 'Sign Up Today <span class="glyphicon glyphicon-pencil"></span>', 'class="btn btn-md btn-primary" data-toggle="modal" data-target="#signup_modal"'); ?></p>
                </div>
            </div>
            <img src="<?=site_url('/assets/img/homepage/crowd for homepage.jpg'); ?>" alt="Hashplan crowd!">
        </div>
        <div class="item">
            <div class="container">
                <div class="carousel-caption">
                    <h2><span id="homepage_timer"></span></h2>
                    <h4>Time to start making plans!</h4>

                    <p><?php echo anchor('signup', 'Sign Up Today <span class="glyphicon glyphicon-pencil"></span>', 'class="btn btn-md btn-primary" data-toggle="modal" data-target="#signup_modal"'); ?></p>
                </div>
            </div>
            <img src="<?=site_url('/assets/img/homepage/baseball game2.jpg'); ?>" alt="Baseball game!">
        </div>
        <div class="item">
            <div class="container">
                <div class="carousel-caption">
                    <div class="col-md-12">
                        <h3>HASHPLAN...WHERE GREAT PLANS START</h3>
                        <h4>Thousands of events at your fingertips</h4>
                    </div>
                    <div class="col-md-12">
                        <?=anchor('signup', 'Sign Up Today <span class="glyphicon glyphicon-pencil"></span>', 'class="btn btn-md btn-primary" data-toggle="modal" data-target="#signup_modal"'); ?>
                    </div>
                </div>
            </div>
            <img src="<?=site_url('/assets/img/homepage/band.jpg'); ?>" alt="Band stage!">
        </div>
    </div>
    <a class="left carousel-control" href="#homepage-slider" data-slide="prev"><span
            class="glyphicon glyphicon-chevron-left"></span></a>
    <a class="right carousel-control" href="#homepage-slider" data-slide="next"><span
            class="glyphicon glyphicon-chevron-right"></span></a>
</div><!-- /.carousel -->
<!-- START THE FEATURETTES -->
<hr class="featurette-divider">
<div class="row featurette">
    <!--<div class = "col-md-6">
        <h2 class = "featurette-heading">How this works?<span class = "text-muted"> It'll blow your mind!</span></h2>
        <p class="lead">Very easy!</p>
    </div>
    -->
    <div class="col-md-6">
        <h2 class="text-muted">How it works?</h2>
    </div>
    <div class="col-md-8 col-md-offset-2">
        <img class="featurette-image img-responsive"
             src="<?=site_url('/assets/img/howitworks/how it works on homepage.jpg'); ?>" alt="How it works!">
    </div>
</div>

<hr class="featurette-divider">
<div class="row featurette">
    <div class="col-md-12">
        <h2 class="text-muted">Cool integration!</h2>
    </div>
    <div class="col-md-11 col-md-offset-1">
        <div class="col-md-2">
            <img class="featurette-image img-responsive"
                 src="<?=site_url('/assets/img/homepage/googlemapsicon.png'); ?>"
                 alt="Google maps integration!">
        </div>
        <div class="col-md-2">
            <img class="featurette-image img-responsive"
                 src="<?=site_url('/assets/img/homepage/YelpLogo1.jpg'); ?>" alt="Yelp integration!">
        </div>
        <div class="col-md-6 col-md-offset-1" style="color: #3276b1;">
            <h4>
                <strong>We've integrated our event data with Google Maps and Yelp! Find out everyting about an event or
                    venue before you go!
                </strong>
            </h4>
        </div>
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
    <div class="col-md-6">
        <h2 class="text-muted">Go Mobile</h2>
    </div>


    <div class="col-md-11 col-md-offset-1">
        <div class="col-md-5 col-md-offset-1" style="color: #3276b1;">
            <h3>
                Coming Soon...Hashplan Mobile App for iPhone and Android
            </h3>
        </div>
        <div class="col-md-2 col-md-offset-2">
            <img class="featurette-image img-responsive"
                 src="<?=site_url('/assets/img/homepage/hmobileapp.png'); ?>" alt="Hashplan Mobile app">
        </div>
    </div>
</div>
<hr>
<div class="container">
    <!--row of columns -->
    <div class="row">
        <div class="col-md-3">
            <h2>Search</h2>

            <p>MANY <span class="text-muted">cool events</span></p>

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

            <p>Browse our listings of thousands of events to discover new activities, venues, musicians, festivals,
                local artists, and more</p>

            <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div>
    </div>
</div>