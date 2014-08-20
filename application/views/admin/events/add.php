<div class="panel panel-default">
    <div class="panel-heading"><h2 class="sub-header"><?= $title;?></h2></div>
    <div class="panel-body">
        <?= validation_errors('<div class="form_error_notification errors alert alert-danger" role="alert">', '</div>') ?>
        <? $eventId = isset($event->event_id) && !empty($event->event_id)?$event->event_id:'';?>
        <form action="<?= site_url('admin/events/add/'.$eventId) ?>" method="POST" class="form-horizontal create-new-event-form"
              role="form">
              <input type="hidden" name="country_selected" id="country_selected" value="<?= isset($country_id) && !empty($country_id) ? $country_id : '';?>">
              <input type="hidden" name="state_selected" id="state_selected" value="<?= isset($venue_state_id) &&!empty($venue_state_id)?$venue_state_id:'';?>">
              <input type="hidden" name="city_selected" id="city_selected" value="<?= isset($venue_city_id) &&!empty($venue_city_id) ? $venue_city_id: '';?>">

            <div class="form-group">

                <label for="event_name" class="col-md-3 control-label"><strong>Event Name:</strong></label>

                <div class="col-md-9">
                    <input type="text" class="form-control" name="name" id="event_name" placeholder="Event Name"
                           value="<?= set_value('name', isset($event->event_name) && !empty($event->event_name)?$event->event_name:'') ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="event_desc" class="col-md-3 control-label"><strong>Description:</strong></label>

                <div class="col-md-9">
                    <textarea cols="30" rows="10" class="form-control event-description" name="description"
                              placeholder="Description"><?= set_value('description', isset($event->event_description)&&!empty($event->event_description)?$event->event_description:'') ?></textarea>
                </div>
            </div>
            <br>

            <div class="form-group">
                <label for="event_date_time" class="col-md-3 control-label"><strong>Event Date/Time:</strong></label>

                <div class="col-md-5">
                    <div class="bfh-datepicker event-date" data-date="<?=set_value('date',isset($event->date)&&!empty($event->date)?$event->date:'today')?>" data-min="today" data-name="date"
                         data-format="y-m-d"></div>
                </div>
                <div class="col-md-4">
                    <div class="bfh-timepicker event-time" data-time="<?=set_value('time',isset($event->time)&&!empty($event->time)?$event->time:'now')?>" data-name="time"></div>
                </div>
            </div>

            <div class="form-group">
                <label for="event_booking_link" class="col-md-3 control-label"><strong>Booking link:</strong></label>

                <div class="col-md-9">
                    <input type="text" class="form-control" name="event_booking_link" id="event_booking_link"
                           placeholder="Booking link"
                           value="<?= set_value('event_booking_link', isset($event->event_booking_link) && !empty($event->event_booking_link)?$event->event_booking_link:'') ?>">
                </div>
            </div>

            <? if (isset($venues) && !empty($venues)): ?>
                <hr>
                <div class="form-group">
                    <div class="col-lg-offset-3 col-lg-9">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="new_venue" id="new_venue" value="1" <?= isset($new_venue) && !empty($new_venue) ? 'checked="checked"' : '';?>> <strong>New Venue</strong>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group" id="autosuggest-venue">

                    <label for="venue" class="col-md-3 control-label"><strong>Event venue:</strong></label>

                    <div class="col-md-9">
                        <div class="input-group">
                            <?= form_dropdown('venue_id', (array)$venues, isset($event->venue_id) && !empty($event->venue_id)?$event->venue_id:'', 'id="venue" class="form-control"');?>
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
                            <button id="toggle">Show underlying select</button>
                        </div>
                    </div>
                </div>

                <div id="new-venue-block">
                    <div class="from-group">
                        <label for="countries" class="col-md-3 control-label"><strong>Country:</strong> </label>
                        <div class="col-md-9" id="countries">
                            <? if (isset($countries) && !empty($countries)): ?>
                                <?= form_dropdown('country_id', $countries, isset($country_id) && !empty($country_id)?$country_id:'', 'id="country_id" class="metro_area btn"');?>
                            <? endif ?>
                        </div>
                    </div>
                    <div class="from-group state-block">
                        <label for="states" class="col-md-3 control-label"><strong>State:</strong> </label>
                        <div class="col-md-9" id="states">
                        </div>
                    </div>
                    <div class="from-group city-block">
                        <label for="city" class="col-md-3 control-label"><strong>City:</strong> </label>
                        <div class="col-md-9" id="cities">
                        </div>
                    </div>   
                    <div class="from-group name-block">
                        <label for="venue_name" class="col-md-3 control-label"><strong>Venue Name:</strong> </label>
                        <div class="col-md-9" id="venue_name">
                        <input type="text" class="form-control" name="venue_name" id="venue_name" placeholder="Venue Name"
                           value="<?= set_value('venue_name', '') ?>">
                        </div>
                    </div>                    
                    <div class="from-group address-block">
                        <label for="venue_address" class="col-md-3 control-label"><strong>Venue Address:</strong> </label>
                        <div class="col-md-9" id="address">
                        <input type="text" class="form-control" name="venue_address" id="venue_address" placeholder="Venue Address"
                           value="<?= set_value('venue_address', '') ?>">
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