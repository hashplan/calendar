<div class="panel panel-default">
    <div class="panel-heading"><h2 class="sub-header">Venues</h2></div>
    <div class="panel-body">
        <div class="table-responsive">
            <table class="table table-striped is_sortable_table" data-url="<?= site_url('admin/venues/venues_list') ?>"
                   data-side-pagination="server" data-pagination="true" data-page-list="[10, 25, 50, 100]"
                   data-search="true" data-query-params="vanue.queryParams">
                <thead>
                <tr>
                    <th class="col-md-1" data-field="venue_id" data-align="right" data-sortable="true">#</th>
                    <th class="col-md-2" data-field="venue_name" data-sortable="true">Venue Name</th>
                    <th class="col-md-2" data-field="venue_address" data-sortable="true">Address</th>
                    <th class="col-md-1" data-field="country_country" data-sortable="true">Country</th>
                    <th class="col-md-1" data-field="state_state" data-sortable="true">State</th>
                    <th class="col-md-1" data-field="venue_city" data-sortable="true">City</th>
                    <th class="col-md-2" data-field="venue_is_sticky" data-sortable="true">Is Excluded</th>
                    <th class="col-md-1" data-field="venue_is_excluded" data-sortable="true">Is Sticky</th>
                    <th class="col-md-1" data-field="actions">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr class="text-center warning">
                    <td colspan="9">There is no data to be displayed</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>