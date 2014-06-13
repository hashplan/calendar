$(function() {
	// filter friends by text input
	$('.page-friends #friends-name').on('keyup', function() {
		fetchFriends();
	});

	function fetchFriends() {
		var url = null;
		if ($('#friends-page-type').val() === 'friends') {
			url = base_url + 'user/friends/friends_list';
		}
		else if ($('#friends-page-type').val() === 'add_friends') {
			url = base_url + 'user/friends/people_you_may_know_list';
		}
		var data = {
			name: $('#friends-name').val()
		};

		if (url !== null) {
			$.ajax(url, {
				type: 'POST',
				data: data,
				success: function(response) {
					$('#friends-list').html(response);
				}
			});
		}
	}
});