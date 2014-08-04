<h2 class="sub-header">Users List</h2>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>First Name</th>
                <th>Last name</th>
                <th>Email</th>
                <th>Group</th>
                <th>Status</th>
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
                        <td>edit|remove</td>
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
