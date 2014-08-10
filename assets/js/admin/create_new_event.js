(function ($) {
    function updateListOfVenues(metro_id) {
        var data = {metro_id: metro_id};
        $.ajax(base_url + 'admin/venues/get_venues_list', {
            type: 'POST',
            data: data,
            success: function (response) {
                $('#venue').empty();
                $.each(response, function (key, value) {
                    $('#venue').append('<option value="' + key + '">' + value + '</option>');
                });
            }
        });
    }

    $(function () {
        $('.create-new-event-form').on('change', '#metro_area_filter', function () {
            if ($(this).val()) {
                updateListOfVenues($(this).val());
            }
        });
    });
})(jQuery);