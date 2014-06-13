$(function() {
	$('.page-friends').on('click', '.remove-from-lists-link', function(e) {
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

	function fetchPeopleYouMayKnow() {
		$.ajax(base_url + 'user/friends/people_you_may_know', {
			type: 'POST',
//			data: data,
			success: function(response) {
				$('#people-you-may-know-list').html(response);
			}
		});
	}
});