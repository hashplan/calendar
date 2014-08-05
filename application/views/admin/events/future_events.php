<h2 class="sub-header">Future Events</h2>
<?if(isset($pagination)&&!empty($pagination)):?>
    <div>
        <?=$pagination?>
    </div>
<?endif?>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>#</th>
            <th>Event Name</th>
            <th>DateTime</th>
            <th>Venue Name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?if(isset($events)&&!empty($events)):?>
            <?foreach($events as $event):?>
                <tr>
                    <td><?=$event->id?></td>
                    <td><?=$event->name?></td>
                    <td><?=$event->date_only?></td>
                    <td><?=$event->venue_name?></td>
                    <td><?=anchor('admin/events/edit/'.$event->id, 'edit')?> | <?=anchor('admin/events/remove/'.$event->id, 'remove')?></td>
                </tr>
            <?endforeach?>
        <?else:?>
            <tr class="text-center warning">
                <td colspan="7">There is no data to be displayed</td>
            </tr>
        <?endif?>
        </tbody>
    </table>
</div>
<?if(isset($pagination)&&!empty($pagination)):?>
    <div>
        <?=$pagination?>
    </div>
<?endif?>