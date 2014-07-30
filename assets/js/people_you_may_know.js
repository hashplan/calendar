(function ($) {
    $(function () {
        $('.page-friends #people-you-may-know-block').on('click', '.remove-from-lists-link', function (e) {
            e.preventDefault();
            var userId = $(this).siblings('.dude-id').val();
            $.ajax(base_url + 'user/friends/remove_from_lists/' + userId, {
                type: 'POST',
                success: function (response) {
                    fetchPeopleYouMayKnow();
                }
            });
        });

        function fetchPeopleYouMayKnow() {
            $.ajax(base_url + 'user/friends/people_you_may_know_block', {
                type: 'POST',
//			data: data,
                success: function (response) {
                    $('#people-you-may-know-block').html(response);
                }
            });
        }
    });
})(jQuery);