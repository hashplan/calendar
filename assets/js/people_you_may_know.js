(function ($) {
    $(function () {
        $('.page-friends #people-you-may-know-block').on('click', '.remove-from-lists-link', function (e) {
            e.preventDefault();
            var url = $(this).attr('href');
            $.ajax(url, {
                type: 'POST',
                success: function (response) {
                    fetchPeopleYouMayKnow();
                }
            });
        });

        function fetchPeopleYouMayKnow() {
            $.ajax(base_url + 'user/friends/people_you_may_know_block', {
                success: function (response) {
                    $('#people-you-may-know-block').html(response);
                }
            });
        }
    });
})(jQuery);