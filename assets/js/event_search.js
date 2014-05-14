$(function() {
	$('.page-dashboard #event_list').on('keyup', function() {
		$.ajax('/user/dashboard/events_list', {
			type: 'POST',
			data: { name: $('#event_list').val() },
			success: function(response) {
				$('#search_result').html(response);
			}
		});
	});

	if ($('.page-dashboard').length > 0) {
		$(window).scroll(function() {
			if($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
				var offset = $('#search_result .panel').length;
				if ($('.no-events-row').length > 0) return;
				$.ajax('/user/dashboard/events_list', {
					type: 'POST',
					data: { name: $('#event_list').val(), offset: offset },
					success: function(response) {
						$(response).appendTo('#search_result');
					}
				});
			}
		});
	}
});