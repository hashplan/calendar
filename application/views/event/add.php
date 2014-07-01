<div class="modal-dialog">
	<div class="modal-content">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<div class="modal-title">Add an event</div>
		</div>
		<div class="modal-body">
			<form>
				<div class="row">
					<div class="col-md-12">
						<input type="text" class="form-control event-name" name="name" placeholder="Event name"/>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<input type="text" class="form-control event-location" name="location" placeholder="Location"/>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="input-group">
							<input type="text" class="form-control event-date" name="date" placeholder="Choose Date"/>
							<span class="input-group-btn">
								<button class="btn btn-default" type="button"><i class="glyphicon glyphicon-calendar"></i></button>
							</span>
						</div>
					</div>
					<div class="col-md-6">
						<div class="bfh-timepicker"></div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<textarea cols="30" rows="10" class="form-control event-description" name="description" placeholder="Description"></textarea>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<input type="checkbox" class="event-private" id="event-private" name="private"/>
						<label for="event-private">Private</label>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<button type="button" class="btn btn-default pull-right close-button" data-dismiss="modal" aria-hidden="true">Close</button>
						<button type="button" class="btn btn-primary pull-right save-button" data-dismiss="modal" aria-hidden="true">Save</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	$('#user_added_event_form .event-date').datepicker({
		format:'yyyy-mm-dd'
	});
	$('#user_added_event_form .bfh-timepicker').bfhtimepicker({
		time: null,
		align: 'right'
	});

	$('#user_added_event_form .save-button').on('click', function() {
		var data = $('#user_added_event_form form').serializeArray();
		$.ajax(base_url +'event/save', {
			type: 'POST',
			data: { data: data },
			success: function(response) {
			}
		});
	});

	// on hide modal - remove all data (this will force twbs to reload modal from remote url)
	$('#user_added_event_form').on('hidden.bs.modal', function() {
		$(this).removeData('bs.modal');
	})
</script>