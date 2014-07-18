<div class="col-md-offset-4 col-md-4 col-sm-12 well">
    <?=validation_errors('<div class="form_error errors alert alert-danger" role="alert">','</div>')?>
    <form action="<?= site_url('login') ?>" method="POST" class="signin-form form-horizontal" role="form">
        <div class="form-group">
            <label for="identity" class="sr-only control-label">Email</label>
            <div class="col-sm-12">
                <input type="email" class="form-control" id="identity" name="identity" value="<?= set_value('identity') ?>"
                       placeholder="Email">
            </div>
        </div>
        <div class="form-group">
            <label for="password" class="sr-only control-label">Password</label>

            <div class="col-sm-12">
                <input type="password" class="form-control" name="password" id="inputPassword3" placeholder="Password">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <?= anchor('forgot_password', lang('login_forgot_password')); ?>
            </div>
            <div class="col-md-6 text-right">
                <?=lang('login_remember_label', 'remember'); ?>
                <?=form_checkbox('remember', '1', FALSE, 'id="remember"'); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-6">
                <a href="<?=site_url('/fb_login'); ?>"><img class="img-responsive"
                                                                    src="<?=site_url('/assets/img/logo/facebooklogin.png'); ?>"
                                                                    alt="Facebook login"></a>
            </div>
            <div class="col-md-offset-2 col-md-4 text-right">
                <button type="submit" class="btn btn-default">Login</button>
            </div>
        </div>
    </form>
</div>