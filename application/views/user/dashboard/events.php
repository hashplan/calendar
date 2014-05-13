<?php if(count($events)):
	foreach ($events as $event):?>
			<div class="panel panel-default" style="background-color:#F8F8F8 ">
				<div class="panel-body">
					<!-- Button trigger modal -->
					<h4><?php echo anchor('event/modal_details/'.$event->eventId, $event->name, 'data-toggle="modal" data-target="#event_modal"');?></h4>
					<p><?php echo $event->name;?><p>
					<?php $d= strtotime($event->datetime); echo "<p>". date("l, F jS, Y @ g:ia",$d)."</p>";?>
					<!--add to events for user id a specific event id-->
					<div class="btn-group event-buttons-wrapper">
						<?php echo anchor('user/dashboard/add_event_to_user/'.$event->eventId, '<i class="glyphicon glyphicon-plus"></i>', array('title' => 'Add to my Events', 'class' => 'btn btn-default')).
							anchor('user/dashboard/delete_event_from_user/'.$event->eventId, '<i class="glyphicon glyphicon-trash"></i>', array('title' => 'Delete Event', 'class' => 'btn btn-default'));?>
					</div>
				</div>
			</div>
	<?php endforeach;
else: ?>
	<div class = "row" style = "background-color: yellow">
		<div class="col-md-12">
			No events found, try going to "All Events" and adding something
		</div>
	</div>
<?php endif;?>