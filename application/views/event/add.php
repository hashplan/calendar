<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="modal-title">Add an event</div>
        </div>
        <div class="modal-body">
            <div class="alert alert-danger errors">
            </div>
            <form>
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
                        <div class="bfh-timepicker"></div>
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
                        <button type="button" class="btn btn-default pull-right close-button" data-dismiss="modal"
                                aria-hidden="true">Close
                        </button>
                        <button type="button" class="btn btn-primary pull-right save-button">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#user_added_event_form .event-date').datepicker({
        format: 'yyyy-mm-dd'
    });
    $('#user_added_event_form .bfh-timepicker').bfhtimepicker({
        time: null,
        align: 'right',
        name: 'time'
    });

    $('#user_added_event_form .save-button').on('click', function () {
        var data = {};
        data.name = $('#user_added_event_form [name="name"]').val();
        data.address = $('#user_added_event_form [name="address"]').val();
        data.location = $('#user_added_event_form [name="location"]').val();
        data.date = $('#user_added_event_form [name="date"]').val();
        data.time = $('#user_added_event_form [name="time"]').val();
        data.description = $('#user_added_event_form [name="description"]').val();
        data.private = $('#user_added_event_form [name="private"]:checked').val();
        $.ajax(base_url + 'event/save', {
            type: 'POST',
            data: data,
            success: function (response) {
                if (typeof response.errors === 'undefined') {
                    $('#user_added_event_form .errors').hide();
                    $('#user_added_event_form').modal('hide');
                    return;
                }
                $('#user_added_event_form .errors').html(response.errors).show();
            }
        });
        return false;
    });

    // on hide modal - remove all data (this will force twbs to reload modal from remote url)
    $('#user_added_event_form').on('hidden.bs.modal', function () {
        $(this).removeData('bs.modal');
    });
</script>