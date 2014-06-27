$(function() {
	// filter friends by text input
	$('.page-friends #friends-name').on('keyup', fetchFriends);

	$('.page-friends #locations-left-block').on('change', '.left-block-location', function() {
		if ($(this).val() === 'all') {
			$('.page-friends #locations-left-block .left-block-location:checked').not($(this)).prop('checked', false);
		}
		else {
			$('.page-friends #locations-left-block #left-block-location-all').prop('checked', false);
		}
		fetchFriends();
	});

	$('.page-friends .locations-show-more-link').on('click', function(e) {
		e.preventDefault();
		var hiddenLocations = $('.page-friends .location-hidden').toArray();
		if ($('.page-friends .location-hidden').length > 0) {
			for (var i in hiddenLocations) {
				if (i > 0) break;
				$(hiddenLocations[i]).slideDown().removeClass('location-hidden');
			}
		}
		if ($('.page-friends .location-hidden').length === 0) {
			$(this).slideUp();
		}
	});

	function fetchFriends() {
		var url = null;
		if ($('#friends-page-type').val() === 'friends') {
			url = base_url + 'user/friends/friends_list';
		}
		else if ($('#friends-page-type').val() === 'add_friends') {
			url = base_url + 'user/friends/people_you_may_know_list';
		}
		else if ($('#friends-page-type').val() === 'friends_invites') {
			url = base_url + 'user/friends/inviters_list';
		}
		else if ($('#friends-page-type').val() === 'invites_sent') {
			url = base_url + 'user/friends/invited_list';
		}
		else if ($('#friends-page-type').val() === 'events_invites') {
			url = base_url + 'user/friends/inviters_events_list';
		}

		var locationIds = [];
		$('.page-friends #locations-left-block .left-block-location:checked').each(function() {
			locationIds.push($(this).val());
		});

		var data = {
			name: $('#friends-name').val(),
			location_ids: locationIds
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