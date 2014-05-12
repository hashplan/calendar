<div class = "container">
		<div class="col-md-2">
		<div class = "thumbnail">
          <img src="<?php echo site_url('/assets/img/users/Stas.jpg');?>", alt="Stas image" class = "img-responsive img-rounded">
		</div>
		<hr>
		
          <!-- Single button -->
		<?php echo anchor('user/dashboard/my_trash/'.$user->id,"<span class='glyphicon glyphicon-trash'> &nbsp</span>Trash",'class = "btn btn-default btn-block"');?>
		<!--<div class="btn-group btn-block">
		  <button type="button" class="btn btn-primary dropdown-toggle btn-block" data-toggle="dropdown">Events <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu" role="menu">
			<li><?php echo anchor('user/dashboard/my_plan/'.$user->id,"Favorites");?></li>
			<li class="divider"></li>
			<li><a href="#">Local Events (in neighborhood)</a></li>
			<li><a href="#">Shared Events</a></li>
			<li><a href="#">Sporting Events</a></li>
			<li><a href="#">Music Events</a></li>
			<li><a href="#">Theater Events</a></li>
			<li><a href="#">Free Events</a></li>
			<li class="divider"></li>
			<li><a href="#">Sponsored Events</a></li>
		  </ul>
		</div>
		-->
  </div>
      <div class = "col-md-8">
			<h4>Welcome <span class="text-muted"><?php echo (string)$user->first_name." " .(string)$user->last_name;?></span></h4>
			<p><?php echo anchor('event/events_per_metro/','Change Location<span class="caret"></span>', 'data-toggle="modal" data-target="#events_per_metro"');?></p>
			<h5>Upcoming Events:</h5>
				<div class = "row">
					<form class="col-md-12">
						<input type="text" id = "event_list" class="form-control" placeholder="Search for events...">
					</form>
				
					<!--<div class = "col-md-3">
						<?php echo anchor('user/dashboard','<span class="glyphicon glyphicon-list-alt"> Full List</span>');?>
						<?php echo anchor('user/dashboard/calendar','<span class="glyphicon glyphicon-calendar"> Calendar</span>');?>
					</div>
					-->
		</div>
		<br>
				<div class = "col-md-12">
					<div class="btn-group">
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Event Category <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu" role="menu">
						<?php if(count($event_categories)):
									foreach ($event_categories as $category):?> 
										<li>
											<?php echo anchor('user/dashboard/filter_events', $category->name);?>
										</li>
							<?php endforeach; else: ?>
											<div class = "row" style = "background-color: yellow">No events found, try going to "All Events" and adding something
											</div>
						<?php endif;?>
					  </ul>
					</div>
					<div class="btn-group">
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Preselects <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu" role="menu">
						<li><a href="#">Next 7 days</a></li>
						<li><a href="#">Next 3 days</a></li>
						<li><a href="#">Upcoming Weekend</a></li>
					  </ul>
					</div>
					<div class="btn-group">
					  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Choose Date <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu" role="menu">
						<div class = "datepicker"></div>
					  </ul>
					</div>
				</div>
			<hr>					
						<div class = "col-md-12" id = "search_result">
							<?php if(count($events)):
									foreach ($events as $event):?> 
										<div class = "row panel panel-info" style = "background-color:#F8F8F8 ">
												<!-- Button trigger modal -->
										<h4><?php echo anchor('event/modal_details/'.$event->eventId, $event->name, 'data-toggle="modal" data-target="#event_modal"');?></h4>
											<p><?php echo $event->name;?><p>
											<?php $d= strtotime($event->datetime); echo "<p>". date("l, F jS, Y @ g:ia",$d)."</p>";?>
											<!--add to events for user id a specific event id-->
											<div class = "col-md-4">
												<span class="glyphicon glyphicon-plus"></span><?php echo anchor('user/dashboard/add_event_to_user/'.$event->eventId,"Add to my Events", 'class = "added"');?>
											</div>
											<div class = "col-md-4">
												<span class="glyphicon glyphicon-remove"></span><?php echo anchor('user/dashboard/delete_event_from_user/'.$event->eventId,"Delete Event", 'class = "deleted"');?>
											</div>
										</div>
									<?php endforeach; else: ?>
											<div class = "row" style = "background-color: yellow">No events found, try going to "All Events" and adding something
											</div>
									<?php endif;?>
						</div>
		</div>
	<div class = "col-md-2">
		<h4>Events of Interest</h4>
			<div>
			<div style = "background-color: gray">place holders</div>
			<div style = "background-color: lightblue">place holders</div>
			<div style = "background-color: darkblue">place holders</div>
			<!--<?php if(isset($cal)): echo $cal; endif;?>-->
			</div>
	</div>
</div>
<!--modal for event details-->
<!-- Modal -->
<div class="modal fade" id="event_modal" tabindex="-1" role="dialog" aria-labelledby="event_modal" aria-hidden="true">
</div>
<!--modal for event per metro-->
<!-- Modal -->
<div class="modal fade" id="events_per_metro" tabindex="-1" role="dialog" aria-labelledby="events_per_metro" aria-hidden="true">
</div>