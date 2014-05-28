<div class = "container">
	<div class="row">
		<div class="col-md-2">
			<div class = "thumbnail">
				<img src="<?php echo site_url('/assets/img/users/Stas.jpg');?>", alt="Stas image" class = "img-responsive img-rounded">
			</div>
			<hr>
			<!-- Single button -->
			<?php echo anchor('user/dashboard/user_added_event',"ADD EVENT",'class = "btn btn-primary btn-block" data-toggle = "modal" data-target = "#user_added_event_form"');?>
			<?php echo anchor('user/dashboard/my_trash/'.$user->id,"<span class='glyphicon glyphicon-trash'> &nbsp</span>Trash",'class = "btn btn-default btn-block"');?>
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
					<button type="button" class="btn btn-default dropdown-toggle" id="event-date" data-toggle="dropdown">Choose Date <span class="caret"></span></button>
					<ul class="dropdown-menu" role="menu">
						<div class="datepicker"></div>
					</ul>
				</div>
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
<div class="modal" id="event_modal" tabindex="-1" role="dialog" aria-labelledby="event_modal" aria-hidden="true">
</div>
<!--modal for event per metro-->
<!-- Modal -->
<div class="modal" id="event_cities" tabindex="-1" role="dialog" aria-labelledby="event_cities" aria-hidden="true">
</div>
<!--modal for private event form-->
<!-- Modal -->
<div class="modal" id="user_added_event_form" tabindex="-1" role="dialog" aria-labelledby="user_added_event_form" aria-hidden="true">
</div>
<!--modal for contact form-->
<!-- Modal -->
<div class="modal" id="contact_form" tabindex="-1" role="dialog" aria-labelledby="contact_form" aria-hidden="true">
</div>