<h4>Welcome <span class="text-muted"><?php echo (string)$user->first_name." " .(string)$user->last_name;?></span></h4>
<div class="city-id" style="display:none"></div>
<h5 class="city-name"></h5>
<p><?php echo anchor('user/dashboard/choose_city','Change Location<span class="caret"></span>', 'data-toggle="modal" data-target="#event_cities"');?></p>
<h5>Upcoming Events:</h5>
<input type="hidden" id="events-type" value="<?php echo $events_type ?>">
<div class = "row">
	<form class="col-md-12">
		<input type="text" id = "event_list" class="form-control" placeholder="Search for events...">
	</form>
</div>
<br>
<div class="row">
	<div class="col-md-4">
		<label for="event-preselects">Categories</label>
		<select name="categories" id="event-categories" class="form-control">
			<option value="0">Doesn't matter</option>
			<?php foreach ($categories as $category) { ?>
				<option value="<?php echo $category->id ?>"><?php echo html_escape($category->name) ?></option>
			<?php } ?>
		</select>
	</div>
	<div class="col-md-4">
		<label for="event-preselects">Day Preselects</label>
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
				No events found, try going to "All Events" and adding something
			</div>
		</div>
	</div>
</div>