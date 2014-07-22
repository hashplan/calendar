$(function() {
	// datepicker
	$('.page-user-events #event-date').datepicker({
		format:'yyyy-mm-dd'
	}).on('changeDate', function(event) {
		$('#event-preselects').val('0');
		fetchEvents();
	});

	// filter events by text input
	$('.page-user-events #event_list').on('keyup', function() {
		fetchEvents();
	});

	// scrolldown handler - fetch 5 more events on page bottom
	if ($('.page-user-events').length > 0) {
		$(window).scroll(function() {
			if($(window).scrollTop() + $(window).height() > $(document).height() - 1) {
				var data = {
					name: $('#event_list').val(),
					offset: $('#search_result .event-row').length
				};
				if ($('.metro-id').text() > 0) {
					data.metro_id = $('.metro-id').text();
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
				var eventsType = 'all';
				if (['favourite', 'deleted', 'my', 'friends'].indexOf($('#events-type').val()) !== -1) {
					eventsType = $('#events-type').val();
				}
				data.events_type = eventsType;
				if ($('#user-id').length > 0) {
					data.user_id = $('#user-id').val();
				}
				data.current_date = $('.date-group:last').val();

				$.ajax(base_url + 'user/events/events_list', {
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
	$('.page-user-events #event_cities').on('click', '.item-metro-name', function(e) {
		e.preventDefault();
		var metroName = $(this).text();
		var metroId = $(this).siblings('.item-metro-id').text();
		$('h5.metro-name').text('Location: '+ metroName);
		$('.metro-id').text(metroId);
		$('#event_cities').modal('hide');
		fetchEvents();
		changePageTitle(metroName);
	});

	// filter events by date presets (next 3 days, next 7 days)
	$('.page-user-events #event-preselects').on('change', function() {
		$('#event-date').val('');
		fetchEvents();
	});

	// filter events by category
	$('.page-user-events #event-categories').on('change', fetchEvents);

	// reset events
	$('.page-user-events #event-reset').on('click', function() {
		$('.metro-id').text('0');
		$('h5.metro-name').text("Location: Doesn't matter");
		$('#event-preselects').val(0);
		$('#event-date').val('');
		$('#event-categories').val(0);
		$('#event_list').val('');
		fetchEvents();
	});

	function fetchEvents() {
		var data = { name: $('#event_list').val() };
		if ($('.metro-id').text() > 0) {
			data.metro_id = $('.metro-id').text();
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

		var eventsType = 'all';
		if (['favourite', 'deleted', 'my', 'friends'].indexOf($('#events-type').val()) !== -1) {
			eventsType = $('#events-type').val();
		}
		data.events_type = eventsType;

		if ($('#user-id').length > 0) {
			data.user_id = $('#user-id').val();
		}

		$.ajax(base_url + 'user/events/events_list', {
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

	function changePageTitle(metroName) {
		var eventsType = null;
		if (['favourite', 'deleted', 'my', 'all'].indexOf($('#events-type').val()) !== -1) {
			eventsType = $('#events-type').val();
		}
		else {
			return;
		}
		var text = ''
		switch (eventsType) {
			case 'all':
				text = metroName === "Doesn't matter" ? 'All events' : 'Events in '+ metroName;
				break;
			case 'my':
				text = metroName === "Doesn't matter" ? 'All my events' : 'My events in '+ metroName;
				break;
			case 'favourite':
				text = metroName === "Doesn't matter" ? 'All favourite events' : 'Favourite events in '+ metroName;
				break;
			case 'deleted':
				text = metroName === "Doesn't matter" ? 'All deleted events' : 'Deleted events in '+ metroName;
				break;
		}
		if (eventsType !== null) {
			$('h2.page-title').text(text);
		}
	}
});