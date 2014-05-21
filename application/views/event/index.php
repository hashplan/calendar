<!--modal for event details-->
<!-- Modal -->
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<div class="modal-title" id="myModalLabel"><?php echo html_escape(date('l, F d', strtotime($event->event_datetime))) ?></div>
		</div>
		<div class="modal-body">
			<ul class="nav nav-tabs">
				<li class="active"><a href="#event" data-toggle="tab">Overview</a></li>
				<li><a href="#venue" data-toggle="tab">Venue</a></li>
				<li><a href="#attendees" data-toggle="tab">Attendees</a></li>
			</ul>

			<div id='content' class="tab-content">
				<div class="tab-pane active" id="event">
					<div class="row">
						<div class="col-md-6">
							<h4><?php echo html_escape($event->event_name) ?></h4>
							<h4><?php echo html_escape($event->venue_name) ?></h4>
							<h4><?php echo html_escape(date('H:i T', strtotime($event->event_datetime))) ?></h4>
						</div>
						<div class="col-md-6">
							<div class="map-holder"></div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="venue">
					<div class="row">
						<div class="col-md-2">
							<img src="<?php echo site_url('/assets/img/event_modal/yelp_logo.jpg'); ?>", alt="Yelp
							logo">
						</div>
						<div class="col-md-6">
							<p>Powered by Yelp</p>
						</div>
					</div>
					<br>

					<div class="row">
						<div class="col-md-6" style="background-color:yellow">
							Yelp Review and info
						</div>
						<div class="col-md-6" style="background-color:#F8F8F8">
							Images of the venue
						</div>
					</div>
					<hr>
					<ul>
						<li>Some Info</li>
						<li>More Info</li>
					</ul>
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
		</div>
	</div>
</div>