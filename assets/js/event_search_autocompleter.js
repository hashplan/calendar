(function ($) {
    $(function () {
        $("#event_list").autocomplete({
            source: base_url + "dashboard/events_autocomplete",
            dataType: 'jsonp',
        });

        $("#event_list").keyup(function () {
            var value = $("#event_list").val();
            $.ajax({
                url: base_url + 'dashboard/events_autocomplete',
                type: 'POST',
                //minLength: 2,
                data: {name: value},
                success: function (event_array) {
                    //$('#search_result').html(event_array);
                    $('#search_result').text("testing the autocomplete: " + value);
                }
            });
        });
    });
})(jQuery);