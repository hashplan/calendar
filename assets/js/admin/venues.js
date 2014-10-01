(function ($) {
    vanue = {
        queryParams: function(params) {
            return {
                limit: params.pageSize,
                offset: params.pageSize * (params.pageNumber - 1),
                search: params.searchText,
                order_by: params.sortName,
                order_type: params.sortOrder
            };
        }
    }

    $(function () {
        $('.is_sortable_table').bootstrapTable();
    });
})(jQuery);