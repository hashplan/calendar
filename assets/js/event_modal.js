$(function() {
	$('#event_modal').on('show.bs.tab', 'a[href="#event"]', function() { console.log('show') });
	$('#event_modal').on('shown.bs.tab', 'a[href="#event"]', function() { console.log('shown') });
	$('#event_modal').on('shown.bs.modal', function(e) {
		var intervalId = setInterval(function() {
			if ($('#event_modal #event .map-holder').length === 1) {
				var venueName = $('#event_modal #event .event-venue-hidden').val();
				var cityName = $('#event_modal #event .event-city-hidden').val();
				$('#event .map-holder').html('\
					<iframe \
						frameborder="0" \
						style="border:0" \
						src="https://www.google.com/maps/embed/v1/place?key=AIzaSyAxw8gzEEn1Kxqvjax4B9siYD0Pi9JoUfg&q='+ venueName +','+ cityName +'"> \
					</iframe>\
				');
				clearInterval(intervalId);
			}
		}, 500)
	});
});