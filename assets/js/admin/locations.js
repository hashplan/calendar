(function ($) {
    function updateListOfStates(country_id) {
        var data = {country_id: country_id};
        $.ajax(base_url + 'admin/locations/get_states_list', {
            type: 'POST',
            data: data,
            success: function (response) {
                $('#state').empty();
                $.each(response, function (key, value) {
                    $('#state').append('<option value="' + key + '">' + value + '</option>');
                });
            }
        });
    }

    $(function () {
        $('.edit-metroarea-form').on('change', '#country_filter', function () {
            if ($(this).val()) {
                updateListOfStates($(this).val());
            }
        });
    });
})(jQuery);