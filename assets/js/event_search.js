(function ($) {
    $(function () {
        // datepicker
        $('.page-user-events #event-date').datepicker({
            format: 'yyyy-mm-dd'
        }).on('changeDate', function (event) {
            $('#event-preselects').val('0');
            fetchEvents();
        });

        // filter events by text input
        $('.page-user-events #event_list').on('keyup', function () {
            fetchEvents();
        });

        function IsOnScreen(s) {
            if ($(s).length > 0) {
                var element = $(s).eq(-2);
                var wst = $(window).scrollTop();
                var wh = $(window).height();
                return (wst < element.offset().top && wst + wh > element.offset().top + element.height()) ? true : false;
            }
            return false;
        }

        var scrolling = false;

        // scrolldown handler - fetch 5 more events on page bottom
        if ($('.page-user-events').length > 0) {
            $(window).scroll(function () {
                if (!scrolling && IsOnScreen('#search_result div.event-row')) {
                    scrolling = true;
                    $('#search_result').append('<div class="event-loader"><img src="' + base_url + '/assets/img/icons/ajax-loader.gif"/></div>');
                    var data = {
                        name: $('#event_list').val(),
                        offset: $('#search_result .event-row').length
                    };
                    if ($('.metro-id').text() > 0) {
                        data.metro_id = $('.metro-id').text();
                    }
                    if ($('#event-preselects').val() != 0) {
                        data.preselects = $('#event-preselects').val();
                    }
                    if ($('#event-date').val().length > 0) {
                        data.specific_date = $('#event-date').val();
                    }
                    if ($('#event-categories').val() != 0) {
                        data.category = $('#event-categories').val();
                    }
                    if ($('.widget-top-venues .venue.active')) {
                        data.venue_id = $('.widget-top-venues .venue.active').data('venue_id');
                    }
                    var eventsType = 'all';
                    if (['favourite', 'deleted', 'my', 'friends', 'trash'].indexOf($('#events-type').val()) !== -1) {
                        eventsType = $('#events-type').val();
                    }
                    data.events_type = eventsType;
                    if ($('#user-id').length > 0) {
                        data.user_id = $('#user-id').val();
                    }
                    data.current_date = $('.date-group:last').val();

                    $.ajax(base_url + 'user/events/events_list', {
                        type: 'POST',
                        data: data,
                        success: function (response) {
                            $('#search_result .event-loader').remove();
                            if(response.trim().length > 0){
                                $(response).appendTo('#search_result');
                                scrolling = false;
                            }
                            else{
                                if($('#search_result div.event-row').length == 0) {
                                    $('#search_result').empty();
                                    $('.no-events-row').addClass('shown').removeClass('hidden');
                                }
                            }
                        }
                    });
                }
                else{
                    if($('#search_result div.event-row').length == 0 && scrolling == false) {
                        $('#search_result').empty();
                        $('.no-events-row').addClass('shown').removeClass('hidden');
                    }
                }
            });
        }

        // fetch events on location selection
        $('.page-user-events #event_cities').on('click', '.item-metro-name', function (e) {
            e.preventDefault();
            var metroName = $(this).text();
            var metroId = $(this).siblings('.item-metro-id').text();
            $('h5.metro-name').text(metroName);
            $('.metro-id').text(metroId);
            $('#event_cities').modal('hide');
            fetchEvents();
            updateTopVenues();
            $('.page-title').data('metro_name', metroName);
            $('.metro-image').css('background-image', 'url(' + $(this).data('picture_path') + ')');


            changePageTitle(metroName);
        });

        // filter events by date presets (next 3 days, next 7 days)
        $('.page-user-events #event-preselects').on('change', function () {
            $('#event-date').val('');
            fetchEvents();
        });

        // filter events by category
        $('.page-user-events #event-categories').on('change', fetchEvents);

        //filter events by venue
        $('.page-user-events .widget-top-venues').on('click', '.venue', function (e) {
            e.preventDefault();
            $('.widget-top-venues .venue').removeClass('active');
            $(this).addClass('active');
            var metroName = $('.page-title').data('metro_name');
            changePageTitle(metroName);
            fetchEvents();
        });

        // reset events
        $('.page-user-events #event-reset').on('click', function () {
            //$('.metro-id').text('0');
            //$('h5.metro-name').text("Location: Doesn't matter");
            $('#event-preselects').val(0);
            $('#event-date').val('');
            $('#event-categories').val(0);
            $('#event_list').val('');
            $('.widget-top-venues .venue').removeClass('active');
            fetchEvents();
        });

        function fetchEvents() {
            var data = { name: $('#event_list').val() };
            if ($('.metro-id').text() > 0) {
                data.metro_id = $('.metro-id').text();
            }
            if ($('#event-preselects').val() != 0) {
                data.preselects = $('#event-preselects').val();
            }
            if ($('#event-date').val().length > 0) {
                data.specific_date = $('#event-date').val();
            }
            if ($('#event-categories').val() != 0) {
                data.category = $('#event-categories').val();
            }
            if ($('.widget-top-venues .venue.active')) {
                data.venue_id = $('.widget-top-venues .venue.active').data('venue_id');
            }

            var eventsType = 'all';
            if (['favourite', 'deleted', 'my', 'friends', 'trash'].indexOf($('#events-type').val()) !== -1) {
                eventsType = $('#events-type').val();
            }
            data.events_type = eventsType;

            if ($('#user-id').length > 0) {
                data.user_id = $('#user-id').val();
            }

            $.ajax(base_url + 'user/events/events_list', {
                type: 'POST',
                data: data,
                success: function (response) {
                    $('#search_result').html(response);
                    if (response.trim().length === 0) {
                        $('.no-events-row').addClass('shown').removeClass('hidden');
                    }
                    else {
                        $('.no-events-row').addClass('hidden').removeClass('shown');
                    }
                }
            });
            $(document).scroll();
        }

        function updateTopVenues() {
            var data = {};
            if ($('.metro-id').text() > 0) {
                data.metro_id = $('.metro-id').text();
            }
            $.ajax(base_url + 'user/events/top_venues_list', {
                type: 'POST',
                data: data,
                success: function (response) {
                    /*$('.widget-top-venues .panel-body').html(response);*/
                    $('.widget-top-venues .list-group').html(response);
                }
            });
        }

        function changePageTitle(metroName) {
            var eventsType = null;
            if (['favourite', 'deleted', 'my', 'friend', 'all'].indexOf($('#events-type').val()) !== -1) {
                eventsType = $('#events-type').val();
            }
            else {
                return;
            }
            var text = ''
            switch (eventsType) {
                case 'all':
                    text = metroName === "Doesn't matter" ? 'All events' : 'Events in ' + metroName;
                    break;
                case 'my':
                    text = metroName === "Doesn't matter" ? 'All my events' : 'My events in ' + metroName;
                    break;
                case 'favourite':
                    text = metroName === "Doesn't matter" ? 'All favourite events' : 'Favourite events in ' + metroName;
                    break;
                case 'deleted':
                    text = metroName === "Doesn't matter" ? 'All deleted events' : 'Deleted events in ' + metroName;
                    break;
            }
            if ($('.widget-top-venues .venue.active .venue-name').text()) {
                text = text + ' - ' + $('.widget-top-venues .venue.active .venue-name').text();
            }

            if (eventsType !== null) {
                $('h2.page-title').text(text);
            }
        }

        var picture_path = $('.metro-image').data('user_location_image');

        if (picture_path != '') {
            $('.metro-image').css('background-image', 'url(' + base_url + picture_path + ')');
        }

        //add to calendar
        $('#search_result').on('click', '.add_event_to_my_plan_btn', function () {
            var that = $(this);
            var event_id = that.parents('.event-row').data('event_id');
            $.ajax(that.attr('href'), {
                type: 'POST',
                success: function (response) {
                    if (response.data && response.data.event_id) {
                        $('.event-' + response.data.event_id + ' .event_labels').append('<span class="label label-primary">In calendar</span>');
                        $(that).remove();
                        $(document).scroll();
                    }
                }
            });
            return false;
        });

        //add/restore to ignore list
        $('#search_result').on('click', '.add_to_ignore_list_btn, .restore_event_btn, .delete_event_from_plan_btn', function () {
            var that = $(this);
            var event_id = that.parents('.event-row').data('event_id');
            $.ajax(that.attr('href'), {
                type: 'POST',
                success: function (response) {
                    if (response.data && response.data.event_id) {
                        $('.event-' + response.data.event_id).remove();
                        $(document).scroll();
                    }
                }
            });
            return false;
        });

    });
})(jQuery);