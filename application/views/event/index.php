	<!--modal for event details-->
<!-- Modal -->
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title" id="myModalLabel"><?php echo $event->name;?></h3>
      </div>
      <div class="modal-body">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#event" data-toggle="tab">Event</a></li>
			<li><a href="#venue" data-toggle="tab">Venue</a></li>
			<li><a href="#map" data-toggle="tab">Map</a></li>
			<li><a href="#attendees" data-toggle="tab">Attendees</a></li>
		</ul>

    <div id='content' class="tab-content">
      <div class="tab-pane active" id="event">
		<div class = "row">
			<div class = "col-md-7">
				<?php $d= strtotime($event->datetime);
				echo "<h3>". date("l",$d)."</h3>";?>
			</div>
			<div class = "col-md-5">
				<?php $d= strtotime($event->datetime);
				echo "<h3>".date("F jS, Y",$d)."</h3>";?>
			</div>
		</div>
		<hr>
			<div class = "row">
				<div class = "col-md-6" style = "background-color: yellow">
					<address>
						<strong>Venue Name</strong><br>
						Street<br>
						City, State ZIP<br>
						P: (123) 456-7890
					</address>
				</div>
				<div class = "col-md-6" style = "background-color: #F8F8F8">
				<p>Action 1</p>
				<p>Action 2</p>
				</div>
			</div>
      </div>
      <div class="tab-pane" id="venue">
        <div class = "row">
			<div class="col-md-2">
					<img src="<?php echo site_url('/assets/img/event_modal/yelp_logo.jpg');?>", alt="Yelp logo">
			</div>
			<div class = "col-md-6">
				<p>Powered by Yelp</p>
			 </div>
		</div>
		<br>
		<div class = "row">
			<div class = "col-md-6" style = "background-color:yellow">
				Yelp Review and info
			</div>
			<div class = "col-md-6"style = "background-color:#F8F8F8">
				Images of the venue
			</div>
		</div>
		<hr>
		<ul>
            <li>Some Info</li>
            <li>More Info</li>
        </ul>
      </div>
      <div class="tab-pane" id="map">
	  <div class = "row">
			<div class = "col-md-8">
				<strong>Venue Name</strong>
			</div>
			<div class = "col-md-4">
					<p>Click Here for Directions</p>
			</div>
	  </div>
	  <br>
	  <div class = "row">
			<div class="col-md-12">
					<!--<img src="<?php echo site_url('/assets/img/event_modal/map_placeholder.jpg');?>", alt="Map">
			-->
				<div id = "map-canvas" class = "map-canvas-event">
				<p>have to figure out the modal google maps issue</p>
				</div>
			</div>
		</div>
		<br>
		<div class = "row">
				<div class = "col-md-6" style = "background-color: yellow">
					<address>
						<strong>Venue Name</strong><br>
						Street<br>
						City, State ZIP<br>
						P: (123) 456-7890
					</address>
				</div>
				<div class = "col-md-6" style = "background-color: #F8F8F8">
				</div>
		</div>
    </div>
	   <div class="tab-pane" id="attendees">
        <ol>
            <li>Attendee</li>
            <li>Attendee</li>
            <li>Attendee</li>
            <li>Attendee</li>
            <li>Attendee</li>
            <li>Attendee</li>
            <li>Attendee</li>
            <li>Attendee</li>
            <li>Attendee</li>
            <li>Attendee</li>
        </ol>
      </div>
    </div>    