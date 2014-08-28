<div class="panel panel-default">
    <div class="panel-heading"><h2 class="sub-header">Metroareas</h2></div>
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
                    <th>Name</th>
                    <th>Related Cities</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <? if (isset($metros) && !empty($metros)): ?>
                    <? foreach ($metros as $metro): ?>
                        <tr>
                            <td><?= $metro->id ?></td>
                            <td><?= $metro->city ?></td>
                            <td><a href="#"><?= $metro->cities_count ?></a></td>
                            <td>
                                <a href="<?= site_url('admin/locations/metroarea/edit/' . $metro->id) ?>"><span class="glyphicon glyphicon-edit"></span></a> |
                                <a href="<?= site_url('admin/locations/metroarea/remove/' . $metro->id) ?>" onclick="return confirm('Are you sure you want to remove this Metroarea?')"><span class="glyphicon glyphicon-remove"></span></a>
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