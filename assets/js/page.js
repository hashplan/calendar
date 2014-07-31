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

    $(function () {
        if ($('#homepage_timer')) {
            startTime();
        }

        //login form
        $('#signin_modal').on('hidden.bs.modal', function () {
            $('.generic-form-errors.form_error', this).empty();
        });
        $('body').on('click', '#signin_modal .alert .close', function () {
            $(this).alert('close');
        });
        $('body').on('submit', '#signin_form', function () {
            var form = $('#signin_form');
            var data = {};
            data.identity = $('#signin_form #identity').val();
            data.password = $('#signin_form #password').val();
            data.remember = $('#signin_form #remember:checked').length ? 1 : 0;

            $.ajax(base_url + 'login', {
                type: 'POST',
                data: data,
                success: function (response) {
                    if (typeof response.errors === 'undefined') {
                        $('.generic-form-errors.form_error').hide();
                        $('#signin_modal').modal('hide');
                        if (response.redirect) {
                            location.href = base_url + response.redirect;
                        }
                        else {
                            location.href = base_url;
                        }
                    }
                    $('.generic-form-errors.form_error').html('<div class="alert alert-danger fade in" role="alert"><button type="button" class="close">×</button>' + response.errors + '</div>')

                }
            });
            return false;
        });

        //signup form
        $('#signup_modal').on('hidden.bs.modal', function () {
            $('.generic-form-errors.form_error', this).empty();
        });
        $('body').on('click', '#signup_modal .alert .close', function () {
            $(this).alert('close');
        });
        $('body').on('submit', '#signup_form', function () {
            var form = $('#signup_form');
            var data = {};
            data.first_name = $('#signup_form #first_name').val();
            data.last_name = $('#signup_form #last_name').val();
            data.email = $('#signup_form #email').val();
            data.password = $('#signup_form #password').val();
            data.password_confirm = $('#signup_form #password_confirm').val();

            $.ajax(base_url + 'signup', {
                type: 'POST',
                data: data,
                success: function (response) {
                    if (typeof response.errors === 'undefined') {
                        $('.generic-form-errors.form_error').hide();
                        $('#signup_form').modal('hide');
                        if (response.redirect) {
                            location.href = base_url + response.redirect;
                        }
                        else {
                            location.href = base_url;
                        }
                    }
                    $('.generic-form-errors.form_error').html('<div class="alert alert-danger fade in" role="alert"><button type="button" class="close">×</button>' + response.errors + '</div>')

                }
            });
            return false;
        });
    });

})(jQuery);