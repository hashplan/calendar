<?php if(count($events)):
	foreach ($events as $event):?>
		<div class="row panel panel-info" style="background-color:#F8F8F8 ">
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