(function ($) {
    $(function () {

        var page = $('body');
        var page_class = 'page-friends';
        if (page.hasClass('page-add-friend')) {
            page_class = 'page-add-friend';
        }
        else if (page.hasClass('page-invites')) {
            page_class = 'page-invites';
        }

        // filter friends by text input
        var delay = (function () {
            var timer = 0;
            return function (callback, ms) {
                clearTimeout(timer);
                timer = setTimeout(callback, ms);
            };
        })();
        $('.' + page_class + ' #friends-name').on('keyup', function () {
            delay(function () {
                fetchFriends();
            }, 500);
        });

        $('.' + page_class + ' #locations-left-block').on('change', '.left-block-location', function () {
            if ($(this).val() === 'all') {
                $('.' + page_class + ' #locations-left-block .left-block-location:checked').not($(this)).prop('checked', false);
            }
            else {
                $('.' + page_class + ' #locations-left-block #left-block-location-all').prop('checked', false);
            }
            $('#locations-enter-name-field').val('');
            fetchFriends();
        });

        $('#locations-enter-name-field').autocomplete({
            source: function (query, responseCallback) {
                $.ajax(base_url + 'user/friends/locations_autocomplete', {
                    type: 'POST',
                    data: { name: query.term },
                    dataType: 'json',
                    success: function (response) {
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
            select: function (event, ui) {
                event.preventDefault();
                $('#locations-enter-name-field').val(ui.item.label);
                fetchFriends();
            },
            open: function () {
                fetchFriends();
            },
            focus: function (event, ui) {
                event.preventDefault();
                $('#locations-enter-name-field').val(ui.item.label);
            }
        });

        function fetchFriends() {
            var url = null;
            var user_id = $('#locations-left-block').data('user_id');
            if ($('#friends-page-type').val() === 'friends' || $('#friends-page-type').val() === 'user_friends') {
                url = base_url + 'user/friends/friends_list/' + user_id;
            }
            else if ($('#friends-page-type').val() === 'add_friends') {
                url = base_url + 'user/friends/users_list';
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
            else if ($('#friends-page-type').val() === 'mutual_friends') {
                url = base_url + 'user/friends/mutual_users_list/' + user_id;
            }
            else if ($('#friends-page-type').val() === 'people_you_may_know') {
                url = base_url + 'user/friends/people_you_may_know_list/';
            }

            var locationIds = [];
            $('.' + page_class + ' #locations-left-block .left-block-location:checked').each(function () {
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
                    success: function (response) {
                        $('#friends-list').html(response);
                        $(window).trigger('scroll');
                    }
                });
            }
            $(document).scroll();
        }

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

        // scrolldown handler
        if ($('.' + page_class).length > 0) {
            $(window).scroll(function () {
                if (!scrolling && IsOnScreen('#friends-list div.friend-row')) {
                    var locationIds = [];
                    var user_id = $('#locations-left-block').data('user_id');
                    $('.' + page_class + ' #locations-left-block .left-block-location:checked').each(function () {
                        locationIds.push($(this).val());
                    });
                    var url = null;
                    var user_id = $('#locations-left-block').data('user_id');
                    if ($('#friends-page-type').val() === 'friends' || $('#friends-page-type').val() === 'user_friends') {
                        url = base_url + 'user/friends/friends_list/' + user_id;
                    }
                    else if ($('#friends-page-type').val() === 'add_friends') {
                        url = base_url + 'user/friends/users_list';
                    }
                    else if ($('#friends-page-type').val() === 'friends_invites') {
                        url = base_url + 'user/friends/inviters_list';
                        return false;
                    }
                    else if ($('#friends-page-type').val() === 'invites_sent') {
                        url = base_url + 'user/friends/invited_list';
                        return false;
                    }
                    else if ($('#friends-page-type').val() === 'events_invites') {
                        url = base_url + 'user/friends/inviters_events_list';
                        return false;
                    }
                    else if ($('#friends-page-type').val() === 'mutualn_friends') {
                        url = base_url + 'user/friends/mutual_users_list/' + user_id;
                    }
                    else if ($('#friends-page-type').val() === 'people_you_may_know') {
                        url = base_url + 'user/friends/people_you_may_know_list/';
                    }

                    var data = {
                        name: $('#friends-name').val(),
                        offset: $('#friends-list .friend-row').length,
                        location_ids: locationIds,
                        location_name: $('#locations-enter-name-field').val()
                    };
                    if ($('.metro-id').text() > 0) {
                        data.metro_id = $('.metro-id').text();
                    }
                    $.ajax(url, {
                        type: 'POST',
                        data: data,
                        success: function (response) {
                            $(response).appendTo('#friends-list');
                            scrolling = false;
                        }
                    });
                }
            });
        }

        function user_lock(user_id){
            var parent = $('.user-' + user_id);
            $('.btn', parent).attr('disabled','disabled');
        }

        function user_unlock(user_id){
            var parent = $('.user-' + user_id);
            $('.btn', parent).removeAttr('disabled');
        }

        $('#friends-list').on('click', '.friend_request_btn, .friend_accept_connetion_btn', function () {
            var that = $(this);
            var user_id = that.parents('.friend-row').data('user_id');
            that.html('<span class="event-loader"><img src="' + base_url + '/assets/img/icons/ajax-loader.gif"/></span>  ' + that.html());
            user_lock(user_id);
            $.ajax(that.attr('href'), {
                type: 'POST',
                success: function (response) {
                    $('.event-loader', that).remove();
                    if (response.data && response.data.user_id) {
                        $('.user-' + response.data.user_id).slideUp(function(){
                            $(this).remove()
                        });
                        $(document).scroll();
                    }
                    else{
                        user_unlock(user_id);
                    }
                }
            });
            return false;
        });

        $('#friends-list').on('click', '.add_to_ignore_list_btn', function () {
            var that = $(this);
            var user_id = that.parents('.friend-row').data('user_id');
            that.html('<span class="event-loader"><img src="' + base_url + '/assets/img/icons/ajax-loader.gif"/></span>  ' + that.html()).attr('disabled','disabled');
            user_lock(user_id);
            $.ajax(that.attr('href'), {
                type: 'POST',
                success: function (response) {
                    $('.event-loader', that).remove();
                    if (response.data && response.data.user_id) {
                        $('.user-' + response.data.user_id).slideUp(function(){
                            $(this).remove()
                        });
                        $(document).scroll();
                    }
                    else{
                        user_unlock(user_id);
                    }
                }
            });
            return false;
        });

        $('#friends-list').on('click', '.remove_from_friendlist_btn', function () {
            var that = $(this);
            var user_id = that.parents('.friend-row').data('user_id');
            that.html('<span class="event-loader"><img src="' + base_url + '/assets/img/icons/ajax-loader.gif"/></span>  ' + that.html()).attr('disabled','disabled');
            user_lock(user_id);
            $.ajax(that.attr('href'), {
                type: 'POST',
                success: function (response) {
                    $('.event-loader', that).remove();
                    if (response.data && response.data.user_id) {
                        $('.user-' + response.data.user_id).slideUp(function(){
                            $(this).remove()
                        });
                        $(document).scroll();
                    }
                    else{
                        user_unlock(user_id);
                    }
                }
            });
            return false;
        });

        function event_lock(user_id){
            var parent = $('.event-' + user_id);
            $('.btn', parent).attr('disabled','disabled');
        }

        function event_unlock(user_id){
            var parent = $('.event-' + user_id);
            $('.btn', parent).removeAttr('disabled');
        }

        $('#friends-list').on('click', '.event_accept_invitation_btn, .event_cancel_invitation_btn', function () {
            var that = $(this);
            var event_id = that.parents('.friend-row').data('event_id');
            that.html('<span class="event-loader"><img src="' + base_url + '/assets/img/icons/ajax-loader.gif"/></span>  ' + that.html()).attr('disabled','disabled');
            event_lock(event_id);
            $.ajax(that.attr('href'), {
                type: 'POST',
                success: function (response) {
                    $('.event-loader', that).remove();

                    if (response.data && response.data.event_id) {
                        $('.event-' + response.data.event_id).slideUp(function(){
                            $(this).remove()
                        });
                        $(document).scroll();
                    }
                    else{
                        event_unlock(event_id);
                    }
                }
            });
            return false;
        });

        $(document).scroll();
    });
})(jQuery);