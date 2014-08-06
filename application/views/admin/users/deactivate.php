<div class="panel panel-default">
    <div class="panel-heading"><h2 class="sub-header"><?= lang('deactivate_heading'); ?></h2></div>
    <div class="panel-body">
        <p><?= sprintf(lang('deactivate_subheading'), $user->username); ?></p>

        <?= form_open("admin/users/deactivate/" . $user->id); ?>

        <p>
            <?= lang('deactivate_confirm_y_label', 'confirm'); ?>
            <input type="radio" name="confirm" value="yes" checked="checked"/>
            <?= lang('deactivate_confirm_n_label', 'confirm'); ?>
            <input type="radio" name="confirm" value="no"/>
        </p>

        <?= form_hidden($csrf); ?>
        <?= form_hidden(array('id' => $user->id)); ?>

        <p><?= form_submit('submit', lang('deactivate_submit_btn')); ?></p>

        <?= form_close(); ?>
    </div>
</div>