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

	$('#locations-enter-name-field').autocomplete({
		source: function(query, responseCallback) {
			$.ajax(base_url +'user/friends/locations_autocomplete', {
				type: 'POST',
				data: { name: query.term },
				dataType: 'json',
				success: function(response) {
					var visibleMetroIds = [];
					$('.page-friends #locations-left-block .left-block-location:visible').each(function() {
						visibleMetroIds.push($(this).attr('id').split('-')[3]);
					});
					var locations = [];
					for (var i in response) {
						var id = response[i].id;
						var name = response[i].city;
						if (visibleMetroIds.indexOf(id) !== -1) {
							continue;
						}
						locations.push({ value: id, label: name });
					}
					responseCallback(locations);
				}
			});
		},
		select: function(event, ui) {
			event.preventDefault();
			var item = ui.item;
			if ($('.page-friends #locations-left-block #left-block-location-'+ item.value).length === 1) {
				$('.page-friends #locations-left-block #left-block-location-'+ item.value).parent().remove();
			}
			if ($('.page-friends #locations-left-block .location-hidden').length === 0) {
				$('#locations-left-block .locations-show-more-link').slideUp();
			}
			$('.page-friends #locations-left-block li:visible:last').after('\
				<li>\
					<input type="checkbox" class="left-block-location" id="left-block-location-'+ item.value +'" value="'+ item.value +'">\
					<label for="left-block-location-'+ item.value +'">'+ item.label +'</label>\
				</li>\
			');
			event.target.value = '';
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