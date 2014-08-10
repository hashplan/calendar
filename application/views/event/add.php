<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="modal-title">Add an event</div>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger errors">
            </div>
            <form action="<?=site_url('event/save')?>" role="form">
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" class="form-control event-name" name="name" placeholder="Event name"/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <input type="text" class="form-control event-location" name="address"
                               placeholder="Event Address"/>
                    </div>
                </div>
                <? if (isset($metros) && !empty($metros)): ?>
                    <div class="row">
                        <div class="col-md-6">
                            <select name="location" class="form-control event-location">
                                <? foreach ($metros as $metro): ?>
                                    <option value="<?= $metro->id ?>"><?= html_escape($metro->city) ?></option>
                                <? endforeach ?>
                            </select>
                        </div>
                    </div>
                <? endif ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control event-date" name="date" placeholder="Choose Date"/>
							<span class="input-group-btn">
								<button class="btn btn-default" type="button"><i
                                        class="glyphicon glyphicon-calendar"></i></button>
							</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bfh-timepicker" data-time="now"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <textarea cols="30" rows="10" class="form-control event-description" name="description"
                                  placeholder="Description"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" class="event-private" id="event-private" name="private"> Private
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" class="btn btn-default pull-right close-button" data-dismiss="modal" aria-hidden="true">Close
                        </button>
                        <button type="button" class="btn btn-primary pull-right save-button">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $('#user_added_event_form .event-date').datepicker({
        format: 'yyyy-mm-dd'
    });
    $('#user_added_event_form .bfh-timepicker').bfhtimepicker({
        time: null,
        align: 'right',
        name: 'time'
    });
</script>