<?foreach ($events as $i => $event):?>
    <?if ($event->date_only !== $current_date):?>
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
        <?$current_date = $event->date_only?>
    <?endif?>
    <div class="panel panel-default event-row">
        <div class="panel-body">
            <!-- Button trigger modal -->
            <h4><?= anchor('event/modal_details/'.$event->id, $event->name, 'data-toggle="modal" data-target="#event_modal"');?></h4>
            <p><?= html_escape($event->venue_name) ?><?if($event->venue_city):?>, <?=$event->venue_city?><?endif?><p>
            <?$d= strtotime($event->datetime);?>
            <p><?=date("l, F jS, Y @ g:ia",$d)?></p>
            <!--add to events for user id a specific event id-->
            <div class="btn-group btn-group-xs event-buttons-wrapper">
                <?= anchor('event/delete_from_favourites/'. $event->id, '<i class="glyphicon glyphicon-trash"></i>', array('title' => 'Unfavourite event', 'class' => 'btn btn-default'));?>
            </div>
        </div>
    </div>
<?endforeach?>