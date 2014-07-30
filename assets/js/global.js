(function ($) {
    $(function () {
        $('body').on('click', '.notification div, .form_error_notification', function () {
            $(this).slideUp().remove();
        });

        var t_notification;

        function set_time_out() {
            t_notification = setTimeout(function () {
                $('body .notification div').each(function () {
                    $(this).slideUp(400, function () {
                        $(this).remove();
                    })
                })
            }, 1800);
        }

        set_time_out();
        function clear_timeout() {
            clearTimeout(t_notification)
        }


        $('body .notification div').hover(clear_timeout, set_time_out);
    });
})(jQuery);