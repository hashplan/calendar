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
		$('#locations-enter-name-field').val('');
		fetchFriends();
	});

	$('#locations-enter-name-field').autocomplete({
		source: function(query, responseCallback) {
			$.ajax(base_url +'user/friends/locations_autocomplete', {
				type: 'POST',
				data: { name: query.term },
				dataType: 'json',
				success: function(response) {
					var locations = [];
					for (var i in response) {
						var id = response[i].id;
						var name = response[i].city;
						locations.push({ value: id, label: name });
					}
					responseCallback(locations);
				}
			});
		},
		select: function(event, ui) {
			event.preventDefault();
			$('#locations-enter-name-field').val(ui.item.label);
			fetchFriends();
		},
		open: function() {
			fetchFriends();
		},
		focus: function(event, ui) {
			event.preventDefault();
			$('#locations-enter-name-field').val(ui.item.label);
		}
	});

	function fetchFriends() {
		var url = null;
        var user_id = $('#locations-left-block').data('user_id');
		if ($('#friends-page-type').val() === 'friends') {
			url = base_url + 'user/friends/friends_list/' + user_id;
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
			location_ids: locationIds,
			location_name: $('#locations-enter-name-field').val()
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