$(function() {
	$('#event_list').on('keyup', function() {
		$.ajax('/user/dashboard/events_list', {
			type: 'POST',
			data: { name: $('#event_list').val() },
			success: function(response) {
				$('#search_result').html(response);
			}
		});
	});
});