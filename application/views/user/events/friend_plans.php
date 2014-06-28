<div class = "container">
	<div class="row">

		<div class="col-md-2">
			<div class = "thumbnail user-avatar">
                <?php if($user->avatar_path){?>
				    <img src="<?php echo site_url('/assets/img/users/'.$user->avatar_path);?>", alt="" class = "img-responsive img-rounded">
			    <?php }else{ ?>
                    <img src="<?php echo site_url('/assets/img/icons/no-image-100.png');?>", alt="" class = "img-responsive img-rounded">
                <?php } ?>
            </div>
			<hr>
		</div>

		<div class="col-md-8">

			<h2><?php echo (string)$user->first_name." " .(string)$user->last_name;?></h2>
			<br>
			<div class="city-id" style="display:none">0</div>
			<h5 class="city-name">Location: Any</h5>
			<p><?php echo anchor('user/events/choose_metro','Change Location<span class="caret"></span>', 'data-toggle="modal" data-target="#event_cities"');?></p>
			<h5>Upcoming Events:</h5>
			<input type="hidden" id="user-id" value="<?php echo $user_id ?>">
			<input type="hidden" id="events-type" value="<?php echo $events_type ?>">
			<div class = "row">
				<div class="col-md-8">
					<input type="text" id = "event_list" class="form-control" placeholder="Search for events...">
				</div>
				<div class="col-md-4">
					<button type="button" class="btn btn-info" id="event-reset">Reset search</button>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-md-4">
					<label for="event-preselects">Categories</label>
					<select name="categories" id="event-categories" class="form-control">
						<option value="0">All</option>
						<?php foreach ($categories as $category) { ?>
							<option value="<?php echo $category->id ?>"><?php echo html_escape($category->name) ?></option>
						<?php } ?>
					</select>
				</div>
				<div class="col-md-4">
					<label for="event-preselects">Day Preselects</label>
					<select name="preselects" id="event-preselects" class="form-control">
						<option value="0">All</option>
						<option value="7">Next 7 days</option>
						<option value="3">Next 3 days</option>
						<option value="weekend">Upcoming Weekend</option>
					</select>
				</div>
				<div class="col-md-4">
					<input type="hidden" name="specific_date" id="date-hidden"/>
					<label for="event-date">Choose specific date</label>
					<input type="text" class="form-control" id="event-date"/>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class = "col-md-12" id = "search_result">
					<?php echo $events ?>
				</div>
			</div>
			<div class="row no-events-row <?php echo ($has_events ? 'hidden' : 'shown') ?>">
				<div class="col-md-12">
					<div class="panel panel-warning">
						<div class="panel-heading">
							No events found, try going to "Events" and adding something
						</div>
					</div>
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