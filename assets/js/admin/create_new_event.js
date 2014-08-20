
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
        
        $('.create-new-event-form').on('show.bfhtimepicker', '.event-time', function () {
            if($('.event-date').hasClass('open')){
                $('.event-date').bfhdatepicker('toggle');
            }
        });
        $('.create-new-event-form').on('show.bfhdatepicker', '.event-date', function () {
            if($('.event-time').hasClass('open')){
                $('.event-time').bfhtimepicker('toggle');
            }
        });
         $.widget( "custom.combobox", {
        _create: function() { 
        this.wrapper = $( "<span>" )
        .addClass( "custom-combobox" )
        .insertAfter( this.element );
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
        },
        _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
        value = selected.val() ? selected.text() : "";
        this.input = $( "<input>" )
        .appendTo( this.wrapper )
        .val( value )
        .attr( "title", "" )
        .addClass( "custom-combobox-input form-control" )
        .autocomplete({
        delay: 0,
        minLength: 0,
        source: $.proxy( this, "_source" )
        })
        .tooltip({
        tooltipClass: "ui-state-highlight"
        });
        this._on( this.input, {
        autocompleteselect: function( event, ui ) {
        ui.item.option.selected = true;
        this._trigger( "select", event, {
        item: ui.item.option
        });
        },
        autocompletechange: "_removeIfInvalid"
        });
        },
        _createShowAllButton: function() {
        var input = this.input,
        wasOpen = false;
        $( "<a>" )
        .attr( "tabIndex", -1 )
        .attr( "title", "Show All Items" )
        .tooltip()
        .appendTo( this.wrapper )
        .button({
        icons: {
        primary: "ui-icon-triangle-1-s"
        },
        text: false
        })
        .removeClass( "ui-corner-all" )
        .addClass( "custom-combobox-toggle ui-corner-right" )
        .mousedown(function() {
        wasOpen = input.autocomplete( "widget" ).is( ":visible" );
        })
        .click(function() {
        input.focus();
        // Close if already visible
        if ( wasOpen ) {
        return;
        }
        // Pass empty string as value to search for, displaying all results
        input.autocomplete( "search", "" );
        });
        },
        _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
        var text = $( this ).text();
        if ( this.value && ( !request.term || matcher.test(text) ) )
        return {
        label: text,
        value: text,
        option: this
        };
        }) );
        },
        _removeIfInvalid: function( event, ui ) {
        // Selected an item, nothing to do
        if ( ui.item ) {
        return;
        }
        // Search for a match (case-insensitive)
        var value = this.input.val(),
        valueLowerCase = value.toLowerCase(),
        valid = false;
        this.element.children( "option" ).each(function() {
        if ( $( this ).text().toLowerCase() === valueLowerCase ) {
        this.selected = valid = true;
        return false;
        }
        });
        // Found a match, nothing to do
        if ( valid ) {
        return;
        }
        // Remove invalid value
        this.input
        .val( "" )
        .attr( "title", value + " didn't match any item" )
        .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
        this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
        },
        _destroy: function() {
        this.wrapper.remove();
        this.element.show();
        }
        });
        $( "#venue" ).combobox();
        $( "#toggle" ).click(function() {
            $( "#combobox" ).toggle();
        });
    });
    $("#new_venue").on ("change", function(){
        if ($('#new_venue').is(':checked'))
        {
            $("#autosuggest-venue").css('display', 'none');
            $("#new-venue-block").css('display', 'block');
        }
        else
        {
            $("#autosuggest-venue").css('display', 'block');
            $("#new-venue-block").css('display', 'none');
        }
    });

    if ($('#new_venue').is(':checked'))
    {
        $("#autosuggest-venue").css('display', 'none');
        $("#new-venue-block").css('display', 'block');
        console.log('state='+$('#state_selected').val())
        console.log('country='+$('#country_selected').val())
        console.log('city='+$('#city_selected').val())

        getCountries($('#country_selected').val());
        getStates($('#country_selected').val(), $('#state_selected').val());
        getCities($('#state_selected').val(), $('#city_selected').val());

        
    } else {
        
    }


    $("#country_id").on ("change", function(){
        var countryId = $(this).val();
        $('#country_selected').val(countryId);
        getStates(countryId);
        getCountries(countryId);

    });
    $(document).on ("change", "#state_id", function(event){
        var stateId = $(this).val();
        $('#state_selected').val(stateId);

        getCities(stateId, $('#city_selected').val());
    });

    $(document).on ("change", "#city_id", function(event){
        var cityId = $(this).val();
        $('#city_selected').val(cityId);

        getCities($('#state_selected').val(), $('#city_selected').val());
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
            url: "/admin/events/getCountries/",
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
            url: "/admin/events/getStates/",
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
            url: "/admin/events/getCities/",
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