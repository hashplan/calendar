(function ($) {
    venue = {
        requestParams: function (params) {
            return {
                limit: params.pageSize,
                offset: params.pageSize * (params.pageNumber - 1),
                search: params.searchText,
                order_by: params.sortName,
                order_type: params.sortOrder
            };
        },
        isStickyFormatter: function (value, row) {
            return '<a href="' + base_url + 'admin/venues/switch_is_sticky/' + row.venue_id + '/' + (value == 1 ? 0 : 1) + '" class="sticky_switcher">' + (value == 1 ? 'Yes' : 'No') + '</a>';
        },
        isExcludedFormatter: function (value, row) {
            return '<a href="' + base_url + 'admin/venues/switch_excluded/' + row.venue_id + '/' + (value == 1 ? 0 : 1) + '" class="excluded_switcher">' + (value == 1 ? 'Yes' : 'No') + '</a>';
        },
        actionFormatter: function (value, row) {
            return '<a href="' + base_url + 'admin/venues/add/' + row.venue_id + '">' +
                '<span class="glyphicon glyphicon-edit"></span></a> | ' +
                '<a href="' + base_url + 'admin/venues/remove/' + row.venue_id + '" ' +
                'onclick="return confirm(\'Are you sure you want to remove this venue?\')">' +
                '<span class="glyphicon glyphicon-remove"></span></a>';
        }

    }

    $(function () {
        $('.is_sortable_table').bootstrapTable();

        $('.is_sortable_table').on('click', '.excluded_switcher', function () {
            var that = $(this);
            $.ajax(that.attr('href'), {
                success: function (response) {
                    if (response.data != 'undefined' && response.data.is_excluded != 'undefined') {
                        that.attr('href', that.attr('href').replace(/\/[0|1]{1}$/g, '/' + (response.data.is_excluded == 1 ? 0 : 1)));
                        that.html((response.data.is_excluded == 1 ? 'Yes' : 'No'));
                    }
                }
            });
            return false;
        });

        $('.is_sortable_table').on('click', '.sticky_switcher', function () {
            var that = $(this);
            $.ajax(that.attr('href'), {
                success: function (response) {
                    if (response.data != 'undefined' && response.data.is_sticky != 'undefined') {
                        that.attr('href', that.attr('href').replace(/\/[0|1]{1}$/g, '/' + (response.data.is_sticky == 1 ? 0 : 1)));
                        that.html((response.data.is_sticky == 1 ? 'Yes' : 'No'));
                    }
                }
            });
            return false;
        });
    });
})(jQuery);