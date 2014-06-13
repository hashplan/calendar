$(function() {
	// filter friends by text input
	$('.page-friends #friends-name').on('keyup', function() {
		fetchFriends();
	});

	function fetchFriends() {
		var data = {
			name: $('#friends-name').val()
		};

		$.ajax(base_url + 'user/friends/friends_list', {
			type: 'POST',
			data: data,
			success: function(response) {
				$('#friends-list').html(response);
			}
		});
	}
});