<? foreach ($events as $i => $event): ?>
    <? if ($event->date_only !== $current_date): ?>
        <div class="panel panel-default event-group-date">
            <div class="panel-body">
                <input type="hidden" class="date-group" value="<?= html_escape($event->date_only) ?>">

                <div class="pull-left event-group-date-day">
                    <?= html_escape(date('l', strtotime($event->date_only))); ?>
                </div>
                <div class="pull-right event-group-date-month">
                    <?= html_escape(date('F d', strtotime($event->date_only))); ?>
                </div>
            </div>
        </div>
        <? $current_date = $event->date_only; ?>
    <? endif ?>
    <div class="panel panel-default event-row event-<?=$event->id?>" data-event_id="<?=$event->id?>">
        <div class="panel-body">
            <!-- Button trigger modal -->
            <h4><?= anchor('event/modal_details/' . $event->id, $event->name, 'data-toggle="modal" data-target="#event_modal"'); ?></h4>
            <div class="event_labels">
                <? if ($event->is_in_calendar_all): ?>
                    <span class="label label-primary">In calendar</span>
                <? endif ?>
                <? if ($event->is_favourite_all): ?>
                    <span class="label label-success">In favorites</span>
                <? endif ?>
            </div>
            <p><?= html_escape($event->venue_name) ?><?if($event->venue_city):?>, <?=$event->venue_city?><?endif?><p>
            <? $d = strtotime($event->datetime); ?>
            <p><?= date("l, F jS, Y @ g:ia", $d) ?></p>
            <!--add to events for user id a specific event id-->
            <div class="btn-group btn-group-xs event-buttons-wrapper">
                <? if (!$event->is_in_calendar_all): ?>
                    <a href="<?=base_url('event/add_to_calendar/' . $event->id)?>" title="Add to Plan" class="btn btn-default add_event_to_my_plan_btn"><i class="glyphicon glyphicon-plus"></i></a>
                <? endif ?>
                <a href="<?=base_url('event/delete_from_user_list/' . $event->id)?>" title="Delete Event" class="btn btn-default add_to_ignore_list_btn"><i class="glyphicon glyphicon-trash"></i></a>
            </div>
        </div>
    </div>
<? endforeach ?>