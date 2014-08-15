<div class="panel panel-default">
    <div class="panel-heading"><h2 class="sub-header"><?= $title;?></h2></div>
    <div class="panel-body">
        <?= validation_errors('<div class="form_error_notification errors alert alert-danger" role="alert">', '</div>') ?>
        <? $eventId = isset($event_id) && !empty($event_id)?'/'.$event_id:'';?>
        <form action="<?= site_url('admin/events/add'.$eventId) ?>" method="POST" class="form-horizontal create-new-event-form"
              role="form">
            <div class="form-group">
                <label for="event_name" class="col-md-3 control-label"><strong>Event Name:</strong></label>

                <div class="col-md-9">
                    <input type="text" class="form-control" name="name" id="event_name" placeholder="Event Name"
                           value="<?= set_value('name', isset($name) && !empty($name)?$name:'') ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="event_desc" class="col-md-3 control-label"><strong>Description:</strong></label>

                <div class="col-md-9">
                    <textarea cols="30" rows="10" class="form-control event-description" name="description"
                              placeholder="Description"><?= set_value('description', isset($description)&&!empty($description)?$description:'') ?></textarea>
                </div>
            </div>
            <br>

            <div class="form-group">
                <label for="event_date_time" class="col-md-3 control-label"><strong>Event Date/Time:</strong></label>

                <div class="col-md-5">
                    <div class="bfh-datepicker event-date" data-date="<?=set_value('date',isset($date)&&!empty($date)?$date:'today')?>" data-min="today" data-name="date"
                         data-format="y-m-d"></div>
                </div>
                <div class="col-md-4">
                    <div class="bfh-timepicker event-time" data-time="<?=set_value('time',isset($time)&&!empty($time)?$time:'now')?>" data-name="time"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="event_booking_link" class="col-md-3 control-label"><strong>Booking link:</strong></label>

                <div class="col-md-9">
                    <input type="text" class="form-control" name="event_booking_link" id="event_booking_link"
                           placeholder="Booking link"
                           value="<?= set_value('event_booking_link', isset($booking_link) && !empty($booking_link)?$booking_link:'') ?>">
                </div>
            </div>

            <? if (isset($venues) && !empty($venues)): ?>
                <hr>
                <div class="form-group">
                    <label for="venue" class="col-md-3 control-label"><strong>Event venue:</strong></label>

                    <div class="col-md-9">
                        <div class="input-group">
                            <?= form_dropdown('venue_id', (array)$venues, isset($venue_id) && !empty($venue_id)?$venue_id:'');?>
                            <? if (isset($metros) && !empty($metros)): ?>
                                <span class="input-group-btn">
                                    <select class="metro_area btn" id="metro_area_filter">
                                        <option value="0">Anywhere</option>
                                        <? foreach ($metros as $metro): ?>
                                            <option value="<?= $metro->id ?>"><?= html_escape($metro->city) ?></option>
                                        <? endforeach ?>
                                    </select>
                                </span>
                            <? endif ?>

                        </div>
                    </div>
                </div>
            <? endif ?>
            <hr>
            <div class="row">
                <div class="col-md-offset-6 col-md-6 text-right">
                    <?= form_submit('submit', $save_button_name, 'class = "btn btn-primary"'); ?>
                    <?= anchor(site_url('admin/users'), "Cancel", 'class = "btn btn-default"'); ?>
                </div>
            </div>
        </form>
    </div>
</div>