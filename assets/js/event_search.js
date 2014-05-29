$(function() {
	// datepicker
	$('.page-dashboard #event-date').datepicker({
		dateFormat:'yy-mm-dd',
		changeMonth: true,
		changeYear: true,
		onSelect: function(dateText) {
			$('#event-preselects').val('0');
			fetchEvents();
		}
	});

	// filter events by text input
	$('.page-dashboard #event_list').on('keyup', function() {
		fetchEvents();
	});

	// scrolldown handler - fetch 5 more events on page bottom
	if ($('.page-dashboard').length > 0) {
		$(window).scroll(function() {
			if($(window).scrollTop() + $(window).height() > $(document).height() - 1) {
				var data = {
					name: $('#event_list').val(),
					offset: $('#search_result .event-row').length
				};
				if ($('.city-id').length > 0) {
					data.city_id = $('.city-id').text();
				}
				if ($('#event-preselects').val() != 0) {
					data.preselects = $('#event-preselects').val();
				}
				if ($('#event-date').val().length > 0) {
					data.specific_date = $('#event-date').val();
				}
				if ($('#event-categories').val() != 0) {
					data.category = $('#event-categories').val();
				}
				$.ajax(base_url + 'user/dashboard/events_list', {
					type: 'POST',
					data: data,
					success: function(response) {
						$(response).appendTo('#search_result');
					}
				});
			}
		});
	}

	// fetch events on location selection
	$('.page-dashboard #event_cities').on('click', '.item-city-name', function(e) {
		e.preventDefault();
		var cityName = $(this).text();
		var cityId = $(this).siblings('.item-city-id').text();
		$('h5.city-name').text(cityName);
		$('.city-id').text(cityId);
		$('#event_cities').modal('hide');
		fetchEvents();
	});

	// filter events by date presets (next 3 days, next 7 days)
	$('#event-preselects').on('change', function() {
		$('#event-date').val('');
		fetchEvents();
	});

	// filter events by category
	$('#event-categories').on('change', fetchEvents);

	function fetchEvents() {
		var data = { name: $('#event_list').val() };
		if ($('.city-id').length > 0) {
			data.city_id = $('.city-id').text();
		}
		if ($('#event-preselects').val() != 0) {
			data.preselects = $('#event-preselects').val();
		}
		if ($('#event-date').val().length > 0) {
			data.specific_date = $('#event-date').val();
		}

		if ($('#event-categories').val() != 0) {
			data.category = $('#event-categories').val();
		}

		$.ajax(base_url + 'user/dashboard/events_list', {
			type: 'POST',
			data: data,
			success: function(response) {
				$('#search_result').html(response);
				if (response.trim().length === 0) {
					$('.no-events-row').addClass('shown').removeClass('hidden');
				}
				else {
					$('.no-events-row').addClass('hidden').removeClass('shown');
				}
			}
		});
	}
});