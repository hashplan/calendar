(function ($) {
//home page timer
    function startTime() {
        var today = new Date();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        var dy = today.getDate();
        var weekday = new Array(7);
        weekday[0] = "Sunday";
        weekday[1] = "Monday";
        weekday[2] = "Tuesday";
        weekday[3] = "Wednesday";
        weekday[4] = "Thursday";
        weekday[5] = "Friday";
        weekday[6] = "Saturday";

        var d = weekday[today.getDay()];

        var month = new Array();
        month[0] = "January";
        month[1] = "February";
        month[2] = "March";
        month[3] = "April";
        month[4] = "May";
        month[5] = "June";
        month[6] = "July";
        month[7] = "August";
        month[8] = "September";
        month[9] = "October";
        month[10] = "November";
        month[11] = "December";

        var mn = month[today.getMonth()];

        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('homepage_timer').innerHTML = d + " " + mn + " " + dy + ", " + h + ":" + m + ":" + s;
        var t = setTimeout(function () {
            startTime()
        }, 500);
    }

    function checkTime(i) {
        if (i < 10) {
            i = "0" + i
        }
        return i;
    }

    if($('#homepage_timer')){
        startTime();
    }

    //contact form
    $('#contact_form').on('submit', function () {
        var form = $('#contact_form');
        var data = {};
        data.user_name = $('#contact_form [name="user_name"]').val();
        data.user_email = $('#contact_form [name="user_email"]').val();
        data.contact_description = $('#contact_form [name="contact_description"]').val();

        $.ajax(base_url + 'contact-us', {
            type: 'POST',
            data: data,
            success: function (response) {
                if (typeof response.errors === 'undefined') {
                    $('.contact_us-form-errors.form_error').hide();
                    $('#contact_form').modal('hide');
                    return;
                }
                if (window.console) {
                    console.log(response);
                }
                $('.contact_us-form-errors.form_error').html(response.errors).show();
            }
        });
        return false;
    });

})(jQuery);