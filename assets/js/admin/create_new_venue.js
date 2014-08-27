
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
        console.log('state='+$('#state_selected').val())
        console.log('country='+$('#country_selected').val())
        console.log('city='+$('#city_selected').val())
        getCountries($('#country_selected').val());
        getStates($('#country_selected').val(), $('#state_selected').val());
        getCities($('#state_selected').val(), $('#city_selected').val());

    $("#country_id").on ("change", function(){
        var countryId = $(this).val();
        $('#country_selected').val(countryId);
        getStates(countryId);
        getCountries(countryId);

    });
    $(document).on ("change", "#state_id", function(event){
        var stateId = $(this).val();
        $('#state_selected').val(stateId);

        getCities(stateId, $('#city_id').val());
    });

    $(document).on ("change", "#city_id", function(event){
        var cityId = $(this).val();
        $('#city_selected').val(cityId);

        getCities($('#state_id').val(), $('#city_id').val());
    });

    });
})(jQuery);

function getCountries(countryId) {
    $.ajax(
        {
            type: "POST",
            data:
                {
                    countryId: countryId,
                },
            dataType: 'json',
            url: "/admin/venues/getCountries/",
            cache: false,
            async: false,
            success: function(ret)
            {
                $('#country_id').html(ret.html);
            }
    });
}

function getStates(countryId, stateId) {
    $.ajax(
        {
            type: "POST",
            data:
                {
                    countryId: countryId,
                    stateId: stateId
                },
            dataType: 'json',
            url: "/admin/venues/getStates/",
            cache: false,
            async: false,
            success: function(ret)
            {
                $('#states').html(ret.html);
                $('.state-block').css('display', 'block');
                $('.city-block').css('display', 'none');
                $('#states').css('margin-top', '10px');
                $('#states').css('margin-bottom', '10px');
                $('.address-block').css('display', 'block');
                $('.name-block').css('display', 'block');
                $('.name-block').css('margin-top', '10px');
                $('#venue_address').css('margin-top', '10px');
                $('#venue_address').css('margin-bottom', '10px');

            }
    });
}

function getCities(stateId, cityId) {
    $.ajax(
        {
            type: "POST",
            data:
                {
                    stateId: stateId,
                    cityId: cityId
                },
            dataType: 'json',
            url: "/admin/venues/getCities/",
            cache: false,
            async: false,
            success: function(ret)
            {
                $('#cities').html(ret.html);
                $('.city-block').css('display', 'block');
                $('#cities').css('margin-bottom', '10px');
                $('.address-block').css('display', 'block');
                $('.name-block').css('display', 'block');
                $('.name-block').css('margin-top', '10px');
                $('#venue_address').css('margin-top', '10px');
                $('#venue_address').css('margin-bottom', '10px');
            }
    });
}