<div class="col-md-offset-4 col-md-4 col-sm-12 well">
    <h1><?php echo lang('forgot_password_heading'); ?></h1>

    <?= validation_errors('<div class="form_error_notification errors alert alert-danger" role="alert">', '</div>') ?>

    <form action="<?= site_url('forgot_password') ?>" method="POST" class="form-horizontal" role="form">
        <div class="form-group">
            <label for="email" class="sr-only control-label">Email</label>

            <div class="col-sm-12">
                <input type="email" class="form-control" id="email" name="email" value="<?= set_value('email') ?>"
                       placeholder="Email">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-12">
                <button type="submit" class="btn btn-default"><?= lang('forgot_password_submit_btn') ?></button>
            </div>
        </div>
    </form>
</div>