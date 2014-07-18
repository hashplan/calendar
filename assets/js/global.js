(function ($) {

    $('body').on('click', '.notification div, .form_error_notification', function(){
        $(this).slideUp();
    });

})(jQuery);