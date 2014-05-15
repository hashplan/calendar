<div class = "container">
	<div class="row">
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
			<div class="city-id" style="display:none">1</div>
			<h5 class="city-name"></h5>
			<p><?php echo anchor('user/dashboard/choose_city','Change Location<span class="caret"></span>', 'data-toggle="modal" data-target="#event_cities"');?></p>
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
			<div class="row">
				<div class="col-md-4">
					<label for="event-preselects">Preselects:</label>
					<select name="preselects" id="event-preselects" class="form-control">
						<option value="0">Doesn't matter</option>
						<option value="7">Next 7 days</option>
						<option value="3">Next 3 days</option>
						<option value="weekend">Upcoming Weekend</option>
					</select>
				</div>
				<div class="col-md-4">
					<input type="hidden" name="specific_date" id="date-hidden"/>
					<label for="event-date">Choose specific date</label>
					<button type="button" class="btn btn-default dropdown-toggle" id="event-date" data-toggle="dropdown">Choose Date <span class="caret"></span></button>
					<ul class="dropdown-menu" role="menu">
						<div class="datepicker"></div>
					</ul>
				</div>
					<!--<div class="btn-group">
						<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">Event Category <span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<?php /*if(count($event_categories)):
								foreach ($event_categories as $category):*/?>
									<li>
										<?php /*echo anchor('user/dashboard/filter_events', $category->name);*/?>
									</li>
								<?php /*endforeach; else: */?>
								<div class = "row" style = "background-color: yellow">No events found, try going to "All Events" and adding something
								</div>
							<?php /*endif;*/?>
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
					-->
			</div>
			<hr>
			<div class="row">
				<div class = "col-md-12" id = "search_result">
					<?php echo $events ?>
				</div>
			</div>
		</div>
		<div class = "col-md-2">
			<h4>Events of Interest</h4>
			<div>
				<div style="background-color: gray">place holders</div>
				<div style="background-color: lightblue">place holders</div>
				<div style="background-color: darkblue">place holders</div>
				<!--<?php if(isset($cal)): echo $cal; endif;?>-->
			</div>
		</div>
	</div>
</div>
<!--modal for event details-->
<!-- Modal -->
<div class="modal fade" id="event_modal" tabindex="-1" role="dialog" aria-labelledby="event_modal" aria-hidden="true">
</div>
<!--modal for event per metro-->
<!-- Modal -->
<div class="modal fade" id="event_cities" tabindex="-1" role="dialog" aria-labelledby="events_per_metro" aria-hidden="true">
</div>