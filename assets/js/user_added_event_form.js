(function ($) {
    $(function () {

        $('#user_added_event_form').on('click', '.save-button', function () {
            var data = {};
            data.name = $('#user_added_event_form [name="name"]').val();
            data.address = $('#user_added_event_form [name="address"]').val();
            data.location = $('#user_added_event_form [name="location"]').val();
            data.date = $('#user_added_event_form [name="date"]').val();
            data.time = $('#user_added_event_form [name="time"]').val();
            data.description = $('#user_added_event_form [name="description"]').val();
            data.private = $('#user_added_event_form [name="private"]:checked').val();
            $.ajax(base_url + 'event/save', {
                type: 'POST',
                data: data,
                success: function (response) {
                    if (typeof response.errors === 'undefined') {
                        $('#user_added_event_form .errors').hide();
                        $('#user_added_event_form').modal('hide');
                        return;
                    }
                    $('#user_added_event_form .errors').html(response.errors).show();
                }
            });
            return false;
        });


        // on hide modal - remove all data (this will force twbs to reload modal from remote url)
        $('#user_added_event_form').on('hidden.bs.modal', function () {
            $(this).removeData('bs.modal');
        });

        $('#user_added_event_form').on('show.bs.modal', function (e) {

        });
    });
})(jQuery);