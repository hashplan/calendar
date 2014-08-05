<h2 class="sub-header">Users List</h2>
<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th data-field="id" data-align="right" data-sortable="true">#</th>
                <th data-field="first_name" data-align="center" data-sortable="true">First Name</th>
                <th data-field="first_name" data-align="center" data-sortable="true">Last name</th>
                <th data-field="email" data-align="center" data-sortable="true">Email</th>
                <th data-field="user_group" data-align="center" data-sortable="true">Group</th>
                <th data-field="active" data-align="center" data-sortable="true">Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?if(isset($users)&&!empty($users)):?>
                <?foreach($users as $user):?>
                    <tr>
                        <td><?=$user->id?></td>
                        <td><?=$user->first_name?></td>
                        <td><?=$user->first_name?></td>
                        <td><?=$user->email?></td>
                        <td><?=$user->user_group?></td>
                        <td><?=$user->active?'Active':'Not Active'?></td>
                        <td><?=anchor('admin/users/edit/'.$user->id, 'edit')?> | <?=anchor('admin/users/remove/'.$user->id, 'remove')?></td>
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