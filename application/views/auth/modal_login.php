<form action="<?= site_url('login') ?>" method="POST" id="signin_form" class="signin-form form-horizontal" role="form">
    <div class="form-group">
        <label for="identity" class="col-md-2 control-label"><strong>Email:</strong></label>
        <div class="col-md-10">
            <input type="text" class="form-control" name="identity" id="identity" placeholder="Email" value="<?=set_value('identity')?>">
        </div>
    </div>
    <div class="form-group">
        <label for="password" class="col-md-2 control-label"><strong><?=lang('login_password_label', 'password'); ?></strong></label>
        <div class="col-md-10">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?=set_value('password')?>">
        </div>
    </div>
    <hr>
    <div class="form-group">
        <div class="col-md-8">
            <a href="<?=site_url('forgot_password')?>"><?php echo lang('login_forgot_password'); ?></a>
        </div>
        <div class="col-md-4 text-right">
            <?=lang('login_remember_label', 'remember'); ?>
            <?=form_checkbox('remember', '1', FALSE, 'id="remember"'); ?>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-8">
            <a href="<?=site_url('fb_login'); ?>"><img class="img-responsive"
                                                       src="<?=site_url('/assets/img/logo/facebooklogin.png'); ?>"
                                                       alt="Facebook login"></a>
        </div>
        <div class="col-md-4 text-right">
            <?=form_submit('submit', 'Login', 'class = "btn btn-primary btn-sm"'); ?>
            <?=anchor(site_url(), "Cancel", 'class = "btn btn-default btn-sm"'); ?>
        </div>
    </div>
</form>