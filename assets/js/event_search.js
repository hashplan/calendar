$(function() {
	$('.page-dashboard #event_list').on('keyup', function() {
		var data = { name: $('#event_list').val() };
		if ($('.city-id').length > 0) {
			data.city_id = $('.city-id').text();
		}
		$.ajax('/user/dashboard/events_list', {
			type: 'POST',
			data: data,
			success: function(response) {
				$('#search_result').html(response);
			}
		});
	});

	if ($('.page-dashboard').length > 0) {
		$(window).scroll(function() {
			if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
				var data = {
					name: $('#event_list').val(),
					offset: $('#search_result .panel').length
				};
				if ($('.city-id').length > 0) {
					data.city_id = $('.city-id').text();
				}
				if ($('.no-events-row').length > 0) return;
				$.ajax('/user/dashboard/events_list', {
					type: 'POST',
					data: data,
					success: function(response) {
						$(response).appendTo('#search_result');
					}
				});
			}
		});
	}

	$('.page-dashboard #event_cities').on('click', '.item-city-name', function(e) {
		e.preventDefault();
		var cityName = $(this).text();
		var cityId = $(this).siblings('.item-city-id').text();
		$('h5.city-name').text(cityName);
		$('.city-id').text(cityId);
		$('#event_cities').modal('hide');

		var data = {
			name: $('#event_list').val(),
			city_id: cityId
		};
		$.ajax('/user/dashboard/events_list', {
			type: 'POST',
			data: data,
			success: function(response) {
				$('#search_result').html(response);
			}
		});
	});
});