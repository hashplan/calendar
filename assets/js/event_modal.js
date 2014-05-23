$(function() {
	$('#event_modal').on('shown.bs.modal', function(e) {
		var intervalId = setInterval(function() {
			if ($('#event_modal #event .map-holder').length === 1) {
				var venueName = $('#event_modal .event-venue-hidden').val();
				var cityName = $('#event_modal .event-city-hidden').val();
				var googleMapsApiKey = $('#event_modal .google-maps-embed-api-key').val();
				$('#event .map-holder').html('\
					<iframe \
						frameborder="0" \
						style="border:0" \
						src="https://www.google.com/maps/embed/v1/place?key='+ googleMapsApiKey +'&q='+ venueName +','+ cityName +'"> \
					</iframe>\
				');
				clearInterval(intervalId);
			}
		}, 500)
	});
	$('#event_modal').on('hidden.bs.modal', function() {
		$(this).removeData('bs.modal');
	})
});