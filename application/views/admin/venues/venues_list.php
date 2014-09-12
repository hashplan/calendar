<div class="panel panel-default">
    <div class="panel-heading"><h2 class="sub-header">Venues</h2></div>
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
                    <th>Venue Name</th>
                    <th>Address</th>
                    <th>Country</th>
                    <th>State</th>
                    <th>City</th>
                    <th>Is Excluded</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <? if (isset($venues) && !empty($venues)): ?>
                    <? foreach ($venues as $venue): ?>
                        <tr <?=$venue->is_excluded == 1?'class="danger"':''?>>
                            <td><?= $venue->venue_id ?></td>
                            <td><?= $venue->venue_name ?></td>
                            <td><?= $venue->venue_address ?></td>
                            <td><?= $venue->venue_country ?></td>
                            <td><?= $venue->venue_state ?></td>
                            <td><?= $venue->venue_city ?></td>
                            <td>
                                <?if($venue->is_excluded == 1):?>
                                    <a href="<?=site_url('admin/venues/switch_excluded/' . $venue->id.'/0')?>">Yes</a>
                                <?else:?>
                                    <a href="<?=site_url('admin/venues/switch_excluded/' . $venue->id.'/1')?>">No</a>
                                <?endif?>
                            </td>
                            <td>
                                <a href="<?= site_url('admin/venues/add/' . $venue->id) ?>"><span class="glyphicon glyphicon-edit"></span></a> |
                                <a href="<?= site_url('admin/venues/remove/' . $venue->id) ?>" onclick="return confirm('Are you sure you want to remove this venue?')"><span class="glyphicon glyphicon-remove"></span></a>
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