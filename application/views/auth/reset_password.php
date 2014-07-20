<div class="col-md-offset-4 col-md-4 col-sm-12 well">
    <h1><?php echo lang('reset_password_heading'); ?></h1>

    <?= validation_errors('<div class="form_error_notification errors alert alert-danger" role="alert">', '</div>') ?>

    <form action="<?= site_url('reset_password/'.$code) ?>" method="POST" class="form-horizontal" role="form">
        <div class="form-group">
            <label for="new_password" class="sr-only control-label"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length); ?></label>
            <div class="col-sm-12">
                <input type="password" class="form-control" id="new_password" name="new" value=""
                       placeholder="New Password">
            </div>
        </div>
        <div class="form-group">
            <label for="new_password_conf" class="sr-only control-label"><?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm'); ?></label>
            <div class="col-sm-12">
                <input type="password" class="form-control" id="new_password_conf" name="new_confirm" value=""
                       placeholder="New Password">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <input type="hidden" name="<?=key($csrf)?>" value="<?=$csrf[key($csrf)]?>"/>
                <input type="hidden" name="user_id" value="<?=$user_id?>"/>
                <button type="submit" class="btn btn-default"><?= lang('forgot_password_submit_btn') ?></button>
            </div>
        </div>
    </form>
</div>