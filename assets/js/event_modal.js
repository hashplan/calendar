(function ($) {
    $(function () {
        // on show modal - load google map into first tab
        $('#event_modal').on('shown.bs.modal', function (e) {
            var eventOwnerId = $('#event_modal .event-owner-id-hidden').val();
            var intervalId = setInterval(function () {
                if (typeof eventOwnerId !== 'undefined') {
                    $('#event_modal #event .map-holder').hide();
                }
                if ($('#event_modal #event .map-holder').length === 1 && typeof eventOwnerId === 'undefined') {
                    var venueName = $('#event_modal .event-venue-hidden').val();
                    var cityName = $('#event_modal .event-city-hidden').val();
                    var address = $('#event_modal .event-address-hidden').val();
                    var googleMapsApiKey = $('#event_modal .google-maps-embed-api-key').val();
                    $('#event .map-holder').html('\
					<iframe \
						frameborder="0" \
						style="border:0" \
						src="https://www.google.com/maps/embed/v1/place?key=' + googleMapsApiKey + '&q=' + venueName + ',' + cityName + ',' + address + '"> \
					</iframe>\
				');
                    clearInterval(intervalId);
                }
            }, 500)
        });

        // on hide modal - remove all data (this will force twbs to reload modal from remote url)
        $('#event_modal').on('hidden.bs.modal', function () {
            $(this).removeData('bs.modal').empty();
        })

        // on open venue tab - fetch info from yelp
        $('#event_modal').on('shown.bs.tab', 'a[href="#venue"]', function () {
            if ($('.yelp-content-holder').hasClass('empty')) {
                var venueName = $('#event_modal .event-venue-hidden').val();
                var cityName = $('#event_modal .event-city-hidden').val();
                var address = $('#event_modal .event-address-hidden').val();
                if(!address){
                    address = cityName;
                }

                $.ajax('/event/yelp', {
                    type: 'POST',
                    dataType: 'html',
                    data: { venue: venueName, city: address },
                    success: function (response) {
                        $('.yelp-content-holder').removeClass('empty').html(response);
                    }
                });
            }
        });

        // add to favourites
        $('#event_modal').on('click', '.button-add-to-favourites', function (e) {
            var eventId = $('#event_modal .event-id-hidden').val();
            $.ajax(base_url + 'event/add_to_favourites/' + eventId, {
                type: 'POST',
                success: function () {
                    var ids = [];
                    $('#event_modal input[type="checkbox"]:checked').each(function () {
                        var id = $(this).attr('id').split('-')[2];
                        ids.push(id);
                    });
                    if ($('#event_modal .is-favourite').hasClass('is-favourite-hidden')) {
                        $('#event_modal .is-favourite').removeClass('is-favourite-hidden').addClass('is-favourite-shown');
                        $('#event_modal .button-add-to-favourites').remove();
                    }
                }
            });
        });

        // add to calendar
        $('#event_modal').on('click', '.button-add-to-calendar', function (e) {
            var eventId = $('#event_modal .event-id-hidden').val();
            $.ajax(base_url + 'event/add_to_calendar/' + eventId, {
                type: 'POST',
                success: function () {
                    if ($('#event_modal .in-calendar').hasClass('in-calendar-hidden')) {
                        $('#event_modal .in-calendar').removeClass('in-calendar-hidden').addClass('in-calendar-shown');
                        $('#event_modal .button-add-to-calendar').remove();
                    }
                }
            });
        });

        // friends autocomplete
        $('#event_modal').delegate('#invite-more-friends-field', 'focus', function () {
            if ($(this).hasClass('ui-autocomplete-input')) {
                return;
            }

            $(this).autocomplete({
                source: function (query, responseCallback) {
                    var excludeIds = [];
                    $('#event_modal #attendees .friend-related-with-event').each(function () {
                        excludeIds.push($(this).data('uid'));
                    });
                    $.ajax(base_url + 'event/invite_friends_autocomplete', {
                        type: 'POST',
                        data: {
                            name: query.term,
                            event_id: $('#event_modal .event-id-hidden').val(),
                            exclude_ids: excludeIds
                        },
                        dataType: 'json',
                        success: function (response) {
                            var friends = [];
                            for (var i in response) {
                                var id = response[i].id;
                                var name = response[i].name;
                                var avatar_path = response[i].avatar_path;
                                friends.push({ value: id, label: name, id: id, name: name, avatar_path: avatar_path})
                            }
                            responseCallback(friends);
                        }
                    });
                },
                select: function (event, ui) {
                    event.preventDefault();
                    var item = ui.item;
                    $.ajax(base_url + 'event/send_invite', {
                        type: 'POST',
                        data: {
                            uid: item.id,
                            event_id: $('#event_modal .event-id-hidden').val()
                        },
                        dataType: 'json',
                        success: function (response) {
                            if (response.result == 'success') {
                                $('#attendees_tmpl').tmpl(item).appendTo('#attendees .friends');
                                if ($('.button-add-to-calendar').length) {
                                    $('.button-add-to-calendar').remove();
                                }

                            }
                        }
                    });
                    event.target.value = '';
                    return false;
                },
                focus: function (event, ui) {
                    event.preventDefault();
                    $('#invite-more-friends-field').val(ui.item.label);
                }
            });
        });
    });
})(jQuery);