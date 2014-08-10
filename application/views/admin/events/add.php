<div class="panel panel-default">
    <div class="panel-heading"><h2 class="sub-header">Create New Event</h2></div>
    <div class="panel-body">
        <?= validation_errors('<div class="form_error_notification errors alert alert-danger" role="alert">', '</div>') ?>
        <form action="<?= site_url('admin/events/add') ?>" method="POST" class="form-horizontal create-new-event-form"
              role="form">
            <div class="form-group">
                <label for="event_name" class="col-md-3 control-label"><strong>Event Name:</strong></label>

                <div class="col-md-9">
                    <input type="text" class="form-control" name="event_name" id="event_name" placeholder="Event Name"
                           value="<?= set_value('event_name') ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="event_desc" class="col-md-3 control-label"><strong>Description:</strong></label>

                <div class="col-md-9">
                    <textarea cols="30" rows="10" class="form-control event-description" name="event_desc"
                              placeholder="Description"><?= set_value('event_desc') ?></textarea>
                </div>
            </div>
            <br>

            <div class="form-group">
                <label for="event_date_time" class="col-md-3 control-label"><strong>Event Date/Time:</strong></label>

                <div class="col-md-5">
                    <div class="bfh-datepicker event-date" data-date="today" data-min="today" data-name="event_date"
                         data-format="y-m-d"></div>
                </div>
                <div class="col-md-4">
                    <div class="bfh-timepicker event-time" data-time="now" data-name="vent_time"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="event_booking_link" class="col-md-3 control-label"><strong>Booking link:</strong></label>

                <div class="col-md-9">
                    <input type="text" class="form-control" name="event_booking_link" id="event_booking_link"
                           placeholder="Booking link"
                           value="<?= set_value('event_booking_link') ?>">
                </div>
            </div>

            <? if (isset($venues) && !empty($venues)): ?>
                <hr>
                <div class="form-group">
                    <label for="venue" class="col-md-3 control-label"><strong>Event venue:</strong></label>

                    <div class="col-md-9">
                        <div class="input-group">
                            <select name="venue" class="form-control venue" id="venue">
                                <? foreach ($venues as $venue): ?>
                                    <option
                                        value="<?= $venue->id ?>"><?= html_escape($venue->venue_name . ' (' . $venue->venue_city . ')') ?></option>
                                <? endforeach ?>
                            </select>

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
                    <?= form_submit('submit', 'Create', 'class = "btn btn-primary"'); ?>
                    <?= anchor(site_url('admin/users'), "Cancel", 'class = "btn btn-default"'); ?>
                </div>
            </div>
        </form>
    </div>
</div>