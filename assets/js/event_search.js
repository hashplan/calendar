$(function() {
	// datepicker
	$('.page-dashboard .datepicker').datepicker({
		format:'yyyy-mm-dd',
		changeMonth: true,
		changeYear: true,
		showOtherMonths: true,
		selectOtherMonths: true,
		//minDate: 0,
		//maxDate: "+1M +10D",
		showButtonPanel: true,
		showOn: "focus",
		onSelect: function(dateText) {
			var dateParts = dateText.split('/');
			$('#event-preselects').val('0');
			$('#date-hidden').val(dateParts[2] +'-'+ dateParts[0] +'-'+ dateParts[1]);
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
				if ($('#date-hidden').val().length > 0) {
					data.specific_date = $('#date-hidden').val();
				}
				if ($('#event-categories').val() != 0) {
					data.category = $('#event-categories').val();
				}
				if ($('.no-events-row').length > 0) return;
				$.ajax(base_url + 'user/dashboard/events_list', {
					type: 'POST',
					data: data,
					success: function(response) {
						$(response).appendTo('#search_result');
						$('.no-events-row').not(':first').remove();
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
		$('#date-hidden').val('');
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
		if ($('#date-hidden').val().length > 0) {
			data.specific_date = $('#date-hidden').val();
		}

		if ($('#event-categories').val() != 0) {
			data.category = $('#event-categories').val();
		}

		$.ajax(base_url + 'user/dashboard/events_list', {
			type: 'POST',
			data: data,
			success: function(response) {
				$('#search_result').html(response);
			}
		});
	}
});