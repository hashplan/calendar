<div class="container">
    <div class="col-md-2">
        <div class="thumbnail user-avatar">
            <img src="<?= site_url('/assets/img/' . ($user->avatar_path ? 'users/' . $user->avatar_path : 'icons/no-image-100.png')) ?>" alt="" class="img-responsive img-rounded"/>
        </div>
        <hr>
    </div>
    <div class="col-md-8">
        <h2>Welcome <span class="text-muted"><?= (string)$user->first_name . " " . (string)$user->last_name; ?></span>
        </h2>
        <h5>Here are your profile details:</h5>

        <div class="row">
            <div class="col-md-3">
            </div>
        </div>
        <hr>
        <div class="col-md-12">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#settings" data-toggle="tab">Settings</a></li>
                <li><a href="#social_accounts" data-toggle="tab">Social Accounts</a></li>
                <li><a href="#teams" data-toggle="tab">Teams</a></li>
                <li><a href="#favorites" data-toggle="tab">Favorites</a></li>
                <li><a href="#other_calendars" data-toggle="tab">Other Calendars</a></li>
            </ul>
            <div id='content' class="tab-content">
                <div class="tab-pane active" id="settings">
                    <div class="row">
                        <div class="col-md-7">
                            <h4>Change your profile picture:</h4>

                            <div id="user_avatar">
                                <form action="<?= site_url('user/settings/avatar') ?>" method="POST"
                                      enctype="multipart/form-data" role="form" class="form-inline">
                                    <div class="form-group">
                                        <label for="userfile" class="sr-only">Avatar</label>
                                        <input id="userfile" type="file" name="userfile" value="">
                                    </div> 
                                    <button type="submit" name="upload" class="btn btn-primary">Upload</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <form action="<?= site_url('user/settings') ?>" role="form" method="POST" autocomplete="off">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group <?= field_error_class('username') ?>">
                                    <label for="account-user-name">Username</label>
                                    <input type="text" class="form-control" id="account-user-name" name="username"
                                           placeholder="Username" value="<?= set_value('username', $user->username) ?>">
                                    <?= form_error('username', '<p class="text-danger">', '</p>') ?>
                                </div>
                                <div class="form-group <?= field_error_class('first_name') ?>">
                                    <label for="account-first-name">First name</label>
                                    <input type="text" class="form-control" id="account-first-name" name="first_name"
                                           placeholder="First name"
                                           value="<?= set_value('first_name', $user->first_name) ?>">
                                    <?= form_error('first_name', '<p class="text-danger">', '</p>') ?>
                                </div>
                                <div class="form-group <?= field_error_class('last_name') ?>">
                                    <label for="account-last-name">Last name</label>
                                    <input type="text" class="form-control" id="account-last-name" name="last_name"
                                           placeholder="Last name"
                                           value="<?= set_value('last_name', $user->last_name) ?>">
                                    <?= form_error('last_name', '<p class="text-danger">', '</p>') ?>
                                </div>
                                <div class="form-group <?= field_error_class('metro_id') ?>">
                                    <label for="account-location">Location</label>
                                    <select class="form-control" id="account-location" name="metro_id">
                                        <option value="0">Select metroarea</option>
                                        <? foreach ($metros as $metro): ?>
                                            <option
                                                value="<?= $metro->id ?>" <? if (isset($account_settings->metroId)): ?><?= set_select('metro_id', $account_settings->metroId, $account_settings->metroId == $metro->id); ?><? endif ?>><?= html_escape($metro->city) ?></option>
                                        <? endforeach ?>
                                    </select>
                                    <?= form_error('metro_id', '<p class="text-danger">', '</p>') ?>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12">
                                <div class="form-group <?= field_error_class('old_password') ?>">
                                    <label for="old-account-password">Old Password</label>
                                    <input type="password" class="form-control" id="old-account-password"
                                           name="old_password"
                                           placeholder="Password" autocomplete="off">
                                    <?= form_error('old_password', '<p class="text-danger">', '</p>') ?>
                                </div>
                                <div class="form-group <?= field_error_class('password') ?>">
                                    <label for="account-password">Password</label>
                                    <input type="password" class="form-control" id="account-password" name="password"
                                           placeholder="Password">
                                    <?= form_error('password', '<p class="text-danger">', '</p>') ?>
                                </div>
                                <div class="form-group <?= field_error_class('password_confirm') ?>">
                                    <label for="account-password-confirm">Confirm Password</label>
                                    <input type="password" class="form-control" id="account-password-confirm"
                                           name="password_confirm" placeholder="Confirm Password">
                                    <?= form_error('password_confirm', '<p class="text-danger">', '</p>') ?>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
                <div class="tab-pane" id="social_accounts">
                    <div class="row">
                        <div class="col-md-12">
                            <a href="<?php echo site_url('/fb_login'); ?>">
                                <img class="img-responsive"
                                     src="<?php echo site_url('/assets/img/logo/facebooklogin.png'); ?>"
                                     alt="Facebook login">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="teams">
                    <div class="row">
                        <div class="col-md-2">
                            <h2>Football</h2>
                            <hr>
                            <h2>Baseball</h2>
                            <hr>
                            <h2>Others</h2>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="favorites">
                    <div class="row">
                        <div class="col-md-2">
                            <h2>Festivals</h2>
                            <hr>
                            <h2>Nightlife</h2>
                            <hr>
                            <h2>Bands</h2>
                            <hr>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="other_calendars">
                    <div class="row">
                        <div class="col-md-2">
                            <h2>Facebook</h2>
                            <hr>
                            <h2>Google</h2>
                            <hr>
                            <h2>Apple</h2>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2" style="background-color: #F8F8F8">
        <h3>placeholder</h3>
    </div>
</div>