$(function() {
	// on show modal - load google map into first tab
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

	// on hide modal - remove all data (this will force twbs to reload modal from remote url)
	$('#event_modal').on('hidden.bs.modal', function() {
		$(this).removeData('bs.modal');
	})

	// on open venue tab - fetch info from yelp
	$('#event_modal').on('shown.bs.tab', 'a[href="#venue"]', function() {
		if ($('.yelp-content-holder').hasClass('empty')) {
			var venueName = $('#event_modal .event-venue-hidden').val();
			var cityName = $('#event_modal .event-city-hidden').val();

			$.ajax('/event/yelp', {
				type: 'POST',
				dataType: 'html',
				data: { venue: venueName, city: cityName },
				success: function(response) {
					$('.yelp-content-holder').removeClass('empty').html(response);
				}
			});
		}
	});

	// add to favourites
	$('#event_modal').on('click', '.button-add-to-favourites', function(e) {
		var eventId = $('#event_modal .event-id-hidden').val();
		$.ajax(base_url +'event/add_to_favourites/'+ eventId, {
			type: 'POST',
			success: function() {
				var ids = [];
				$('#event_modal input[type="checkbox"]:checked').each(function() {
					var id = $(this).attr('id').split('-')[2];
					ids.push(id);
				});
				if (ids.length > 0) {
					$.ajax(base_url +'user/friends/send_multiple_event_invites', {
						type: 'POST',
						data: { friend_ids: ids, event_id: $('#event_modal .event-id-hidden').val() }
					});
				}
				if ($('#event_modal .is-favourite').hasClass('is-favourite-hidden')) {
					$('#event_modal .is-favourite').removeClass('is-favourite-hidden').addClass('is-favourite-shown');
					$('#event_modal .button-add-to-favourites').remove();
				}
			}
		});
	});
});