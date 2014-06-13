$(function() {
	$('.page-friends #people-you-may-know-block').on('click', '.remove-from-lists-link', function(e) {
		e.preventDefault();
		var userId = $(this).siblings('.dude-id').val();
		$.ajax(base_url + 'user/friends/remove_from_lists', {
			type: 'POST',
			data: { user_id: userId },
			success: function(response) {
				fetchPeopleYouMayKnow();
			}
		});
	});
	$('.page-friends #people-you-may-know-block').on('click', '.connect-link', function(e) {
		e.preventDefault();
		var url = $(this).attr('href');
		$.ajax(url, {
			type: 'POST',
//			data: data,
			success: function(response) {
			}
		});
	});

	function fetchPeopleYouMayKnow() {
		$.ajax(base_url + 'user/friends/people_you_may_know_block', {
			type: 'POST',
//			data: data,
			success: function(response) {
				$('#people-you-may-know-block').html(response);
			}
		});
	}
});