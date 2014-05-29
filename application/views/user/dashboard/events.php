<?php
$current_date = NULL;
foreach ($events as $i => $event) {
	if ($event->date_only !== $current_date) { ?>
		<div class="panel panel-default" style="background-color:#F8F8F8">
			<div class="panel-body">
				<div class="pull-left event-group-date event-group-date-day">
					<?php echo html_escape(date('l', strtotime($event->date_only))); ?>
				</div>
				<div class="pull-right event-group-date event-group-date-month">
					<?php echo html_escape(date('F d', strtotime($event->date_only))); ?>
				</div>
			</div>
		</div>
		<?php $current_date = $event->date_only;
	} ?>
	<div class="panel panel-default event-row">
		<div class="panel-body">
			<!-- Button trigger modal -->
			<h4><?php echo anchor('event/modal_details/'.$event->id, $event->name, 'data-toggle="modal" data-target="#event_modal"');?></h4>
			<p><?php echo html_escape($event->name) ?><p>
			<?php $d= strtotime($event->datetime); echo "<p>". date("l, F jS, Y @ g:ia",$d)."</p>";?>
			<!--add to events for user id a specific event id-->
			<div class="btn-group btn-group-xs event-buttons-wrapper">
				<?php echo anchor('user/dashboard/add_event_to_user/'.$event->id, '<i class="glyphicon glyphicon-plus"></i>', array('title' => 'Add to my Events', 'class' => 'btn btn-default')).
					anchor('event/delete/'.$event->id, '<i class="glyphicon glyphicon-trash"></i>', array('title' => 'Delete Event', 'class' => 'btn btn-default'));?>
			</div>
		</div>
	</div>
<?php } ?>