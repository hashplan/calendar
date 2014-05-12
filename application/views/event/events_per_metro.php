<!--modal for event details-->
<!-- Modal -->
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h3 class="modal-title" id="myModalLabel">Select City - still working on join query</h3>
      </div>
      <div class="modal-body">
<div class = "col-md-12" id = "search_result">
	<?php if(count($events_per_metro)):
		foreach ($events_per_metro as $metro):?> 
			<div class = "row panel panel-info" style = "background-color:#F8F8F8 ">
					<!-- Button trigger modal -->
			<h4><?php echo anchor('event/modal_details/'.$event->eventId, $event->name, 'data-toggle="modal" data-target="#event_modal"');?></h4>
				<!--add to events for user id a specific event id-->
				<div class = "col-md-4">
					<span class="badge"><?php echo $metro->count;?></span>
				</div>
				<div class = "col-md-4">
					<span class="glyphicon glyphicon-remove"></span><?php echo anchor('user/dashboard/delete_event_from_user/'.$event->eventId,"Delete Event", 'class = "deleted"');?>
				</div>
			</div>
	<?php endforeach; else: ?>
			<div class = "row" style = "background-color: yellow">No events found, try going to "Events" and adding something
			</div>
	<?php endif;?>
	</div>