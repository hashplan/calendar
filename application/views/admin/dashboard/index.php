<!-- START THE FEATURETTES -->
      <hr class="featurette-divider">
<div class = "container">
		<div class="col-md-2">
          <img src="<?php echo site_url('/assets/img/users/'.$user->avatart_path);?>", alt="">
		<hr>
          <!-- Single button -->
		<div class="btn-group">
		  <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">Events <span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu" role="menu">
			<li><?php echo anchor('admin/dashboard/my_plan/'.$user->id,"Favorites");?></li>
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
        </div>
      <div class = "col-md-6">
			<h4>Welcome <span class="text-muted"><?php echo (string)$user->first_name." " .(string)$user->last_name;?></span></h4>
			<h5>Upcoming Events:</h5>
				<div class = "row">
					<form class="col-md-9">
						<input type="text" id = "event_list" class="form-control" placeholder="Search for events...">
					</form>
					<div class = "col-md-3">
						<?php echo anchor('admin/dashboard','<span class="glyphicon glyphicon-list-alt"> Full List</span>');?>
						<?php echo anchor('admin/dashboard/calendar','<span class="glyphicon glyphicon-calendar"> Calendar</span>');?>
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
												<span class="glyphicon glyphicon-plus"></span><?php echo anchor('admin/dashboard/add_event_to_user/'.$event->eventId,"Add to my Events", 'class = "added"');?>
											</div>
											<div class = "col-md-4">
												<span class="glyphicon glyphicon-remove"></span><?php echo anchor('admin/dashboard/delete_event_from_user/'.$event->eventId,"Delete Event", 'class = "deleted"');?>
											</div>
										</div>
									<?php endforeach; else: ?>
											<div class = "row" style = "background-color: yellow">No events found, try going to "All Events" and adding something
											</div>
									<?php endif;?>
						</div>
		</div>
	<div class = "col-md-4">
		<h3>Calendar</h3>
			<div class="datepicker">
			</div>
			<div class = "mycal">
			<h3>calendar with static (for now) links to events on the day</h3>
			<?php if(isset($cal)): echo $cal; endif;?>
			</div>
	</div>
</div>
<!--modal for event details-->
<!-- Modal -->
<div class="modal fade" id="event_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
</div>