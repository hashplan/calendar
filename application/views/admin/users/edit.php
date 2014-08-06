<div class="panel panel-default">
    <div class="panel-heading">
        <h2 class="sub-header"><?= lang('edit_user_heading'); ?></h2>

        <p><?= lang('edit_user_subheading'); ?></p>
    </div>
    <div class="panel-body">

        <?= validation_errors('<div class="form_error_notification errors alert alert-danger" role="alert">', '</div>') ?>
        <form action="<?= site_url('admin/users/edit/' . $user->id) ?>" method="POST" class="form-horizontal"
              role="form">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="first_name" class="col-md-3 control-label"><strong>First Name:</strong></label>

                        <div class="col-md-9">
                            <input type="text" class="form-control" name="first_name" id="first_name"
                                   placeholder="First Name"
                                   value="<?= set_value('first_name', $user->first_name) ?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="last_name" class="col-md-3 control-label"><strong>Last Name:</strong></label>

                        <div class="col-md-9">
                            <input type="text" class="form-control" name="last_name" id="last_name"
                                   placeholder="Last Name"
                                   value="<?= set_value('last_name', $user->last_name) ?>">
                        </div>
                    </div>
                    <fieldset>
                        <legend class="col-md-offset-3 col-md-9"><?= lang('edit_user_groups_heading'); ?></legend>
                        <?php foreach ($groups as $group): ?>
                            <? $gID = $group['id']; ?>
                            <? $checked = null; ?>
                            <? $item = null; ?>
                            <? foreach ($currentGroups as $grp): ?>
                                <? if ($gID == $grp->id): ?>
                                    <? $checked = ' checked="checked"'; ?>
                                    <? break; ?>
                                <? endif ?>
                            <? endforeach ?>
                            <div class="form-group">
                                <div class="col-md-offset-3 col-md-9">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="groups[]"
                                                   value="<?php echo $group['id']; ?>"<?php echo $checked; ?>> <?php echo $group['name']; ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </fieldset>

                </div>
                <div class="col-md-6 col-sm-12">
                    <div class="form-group">
                        <label for="password" class="col-md-3 control-label"><strong>Password:</strong></label>

                        <div class="col-md-9">
                            <input type="password" class="form-control" name="password" id="password"
                                   placeholder="Password"
                                   value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password_confirm" class="col-md-3 control-label"><strong>Confirm:</strong></label>

                        <div class="col-md-9">
                            <input type="password" class="form-control" name="password_confirm" id="password_confirm"
                                   placeholder="Confirm Password" value="">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="form-group">
                        <div class="col-md-offset-3 col-md-9 text-right">
                            <?php echo form_hidden($csrf); ?>
                            <?php echo form_hidden('id', $user->id); ?>
                            <?php echo form_submit('submit', lang('edit_user_submit_btn'), 'class = "btn btn-primary"'); ?>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>