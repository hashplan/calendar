<div class="panel panel-default">
    <div class="panel-heading"><h2 class="sub-header">Future Events</h2></div>
    <div class="panel-body">
        <? if (isset($pagination) && !empty($pagination)): ?>
            <div>
                <?= $pagination ?>
            </div>
        <? endif ?>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Event Name</th>
                    <th>DateTime</th>
                    <th>Venue Name</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <? if (isset($events) && !empty($events)): ?>
                    <? foreach ($events as $event): ?>
                        <tr>
                            <td><?= $event->id ?></td>
                            <td><?= $event->name ?></td>
                            <td><?= $event->date_only ?></td>
                            <td><?= $event->venue_name ?></td>
                            <td><?= $event->status ?></td>
                            <td>
                                <a href="<?= site_url('admin/events/add/' . $event->id) ?>"><span class="glyphicon glyphicon-edit"></span></a> |
                                <a href="<?= site_url('admin/events/remove/' . $event->id) ?>" onclick="return confirm('Are you sure you want to remove this event?')"><span class="glyphicon glyphicon-remove"></span></a>
                            </td>
                        </tr>
                    <? endforeach ?>
                <? else: ?>
                    <tr class="text-center warning">
                        <td colspan="7">There is no data to be displayed</td>
                    </tr>
                <?endif ?>
                </tbody>
            </table>
        </div>
        <? if (isset($pagination) && !empty($pagination)): ?>
            <div>
                <?= $pagination ?>
            </div>
        <? endif ?>
    </div>
</div>