<div class="panel panel-default">
    <div class="panel-heading"><h2 class="sub-header"><?= $title;?></h2></div>
    <div class="panel-body">
        <?= validation_errors('<div class="form_error_notification errors alert alert-danger" role="alert">', '</div>') ?>
        <? $venueId = isset($venue->venue_id) && !empty($venue->venue_id)?$venue->venue_id:'';?>
        <form action="<?= site_url('admin/venues/add/'.(isset($venue->venue_id)&&!empty($venue->venue_id)?$venue->venue_id:'')) ?>" method="POST" class="form-horizontal create-new-event-form"
              role="form">
              <input type="hidden" name="country_selected" id="country_selected" value="<?= isset($country_id) && !empty($country_id) ? $country_id : '';?>">
              <input type="hidden" name="state_selected" id="state_selected" value="<?= isset($venue->stateId) &&!empty($venue->stateId)?$venue->stateId:'';?>">
              <input type="hidden" name="city_selected" id="city_selected" value="<?= isset($venue->cityId) &&!empty($venue->cityId) ? $venue->cityId: '';?>">
            <input type="hidden" name="venue_id" id="venue_id" value="<?= isset($venue_id) &&!empty($venue_id) ? $venue_id: '';?>">
            <div class="form-group">

                <label for="name" class="col-md-3 control-label"><strong>Venue Name:</strong></label>

                <div class="col-md-9">
                    <input type="text" class="form-control" name="name" id="name" placeholder="Venue Name"
                           value="<?= set_value('name', isset($venue->name) && !empty($venue->name)?$venue->name:'') ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="event_desc" class="col-md-3 control-label"><strong>Description:</strong></label>

                <div class="col-md-9">
                    <textarea cols="30" rows="10" class="form-control event-description" name="description"
                              placeholder="Description"><?= set_value('description', isset($venue->description)&&!empty($venue->description)?$venue->description:'') ?></textarea>
                </div>
            </div>
            <br>


            <div class="form-group">
                <label for="address" class="col-md-3 control-label"><strong>Address:</strong></label>

                <div class="col-md-9">
                    <input type="text" class="form-control" name="address" id="address"
                           placeholder="Address"
                           value="<?= set_value('address', isset($venue->address) && !empty($venue->address)?$venue->address:'') ?>">
                </div>
            </div>
                    <div class="form-group">
                        <label for="phone" class="col-md-3 control-label"><strong>Venue Phone:</strong> </label>
                        <div class="col-md-9">
                        <input type="text" class="form-control" name="phone" id="phone" placeholder="Phone"
                           value="<?= set_value('phone', isset($venue->phone)&&!empty($venue->phone)?$venue->phone:'') ?>">
                        </div>
                    </div>                    
                    <div class="form-group">
                        <label for="website" class="col-md-3 control-label"><strong>Venue website:</strong> </label>
                        <div class="col-md-9">
                        <input type="text" class="form-control" name="website" id="website" placeholder="Venue Website"
                           value="<?= set_value('website', isset($venue->website)&&!empty($venue->website)?$venue->website:'') ?>">
                        </div>
                    </div>                 
                    <div class="form-group">
                        <label for="zip" class="col-md-3 control-label"><strong>Zip Code:</strong> </label>
                        <div class="col-md-9">
                        <input type="text" class="form-control" name="zip" id="zip" placeholder="Zip Code"
                           value="<?= set_value('zip', isset($venue->zip)&&!empty($venue->zip)?$venue->zip:'') ?>">
                        </div>
                    </div>   
                <hr>
                    <div class="form-group">
                        <label for="countries" class="col-md-3 control-label"><strong>Country:</strong> </label>
                        <div class="col-md-9" id="countries">
                            <? if (isset($countries) && !empty($countries)): ?>
                                <?= form_dropdown('country_id', $countries, isset($country_id) && !empty($country_id)?$country_id:'', 'id="country_id" class="metro_area btn"');?>
                            <? endif ?>
                        </div>
                    </div>
                    <div class="form-group state-block">
                        <label for="states" class="col-md-3 control-label"><strong>State:</strong> </label>
                        <div class="col-md-9" id="states">
                        </div>
                    </div>
                    <div class="form-group city-block">
                        <label for="city" class="col-md-3 control-label"><strong>City:</strong> </label>
                        <div class="col-md-9" id="cities">
                        </div>
                    </div>   
                                  

            <hr>
            <div class="row">
                <div class="col-md-offset-6 col-md-6 text-right">
                    <?= form_submit('submit', $save_button_name, 'class = "btn btn-primary"'); ?>
                    <?= anchor(site_url('admin/venues'), "Cancel", 'class = "btn btn-default"'); ?>
                </div>
            </div>
        </form>
    </div>
</div>