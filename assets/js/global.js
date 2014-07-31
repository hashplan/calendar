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

        //contact form
        $('#contact_modal').on('hidden.bs.modal', function () {
            $('.generic-form-errors.form_error', this).empty();
        });
        $('body').on('click', '#contact_modal .alert .close', function () {
            $(this).alert('close');
        });
        $('body').on('submit', '#contact_form', function () {
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
                        $('#contact_modal').modal('hide');
                        return;
                    }
                    $('.contact_us-form-errors.form_error').html('<div class="alert alert-danger fade in" role="alert"><button type="button" class="close">×</button>' + response.errors + '</div>');
                }
            });
            return false;
        });
    });
})(jQuery);