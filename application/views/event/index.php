<!--modal for event details-->
<!-- Modal -->
<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<div class="modal-title" id="myModalLabel"><?php echo html_escape(date('l, F d', strtotime($event->event_datetime))) ?></div>
            <span class="label label-success is-favourite is-favourite-<?php echo $is_my ? 'shown' : 'hidden'?>">My event</span>
            <span class="label label-success is-favourite is-favourite-<?php echo $is_favourite ? 'shown' : 'hidden'?>">In favourites</span>
		</div>
		<div class="modal-body">
			<input type="hidden" class="google-maps-embed-api-key" value="<?php echo $google_maps_embed_api_key ?>"/>
			<input type="hidden" class="event-id-hidden" value="<?php echo urlencode($event->event_id) ?>"/>
			<input type="hidden" class="event-name-hidden" value="<?php echo urlencode($event->event_name) ?>"/>
			<input type="hidden" class="event-venue-hidden" value="<?php echo urlencode($event->venue_name) ?>"/>
			<input type="hidden" class="event-city-hidden" value="<?php echo urlencode(($event->city_city ? $event->city_city : $event->venue_city)) ?>"/>
			<input type="hidden" class="event-owner-id-hidden" value="<?php echo urlencode($event->event_owner_id) ?>"/>
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
							<?php if ($event->event_stubhub_url) { ?>
								<?php echo anchor('http://www.stubhub.com/'. $event->event_stubhub_url, 'Need tickets?') ?>
							<?php } ?>
						</div>
						<div class="col-md-6">
							<div class="map-holder"></div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="venue">
					<div class="yelp-content-holder empty">
					</div>
				</div>
				<div class="tab-pane" id="attendees">
					<div class="row">
						<?php foreach ($friends_you_can_invite_on_event as $friend) { ?>
							<div class="col-md-6 friend-you-can-invite">
								<input type="checkbox" id="invite-friend-<?php echo $friend->id ?>">
								<img src="/assets/img/icons/no-image-100.png">
								<label for="invite-friend-<?php echo $friend->id ?>"><?php echo html_escape($friend->name) ?></label>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<?php if (!$in_calendar) { ?>
				<button type="button" class="btn btn-primary button-add-to-calendar">Add to calendar</button>
			<?php }
			if (!$is_favourite) { ?>
				<button type="button" class="btn btn-success button-add-to-favourites">Add to favourites</button>
			<?php } ?>
			<button type="button" class="btn btn-default button-close" data-dismiss="modal" aria-hidden="true">Close</button>
		</div>
	</div>
</div>