<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo site_url(''); ?>"><img
                    src="<?php echo site_url('/assets/img/logo/hashplan_150-28.png'); ?>" alt="Hashplan logo"></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><?php echo anchor('', 'Home'); ?></li>
                <li><a href="<?php echo site_url('page/about'); ?>">About</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <? if ($this->ion_auth->logged_in()): ?>
                    <li class="dropdown nav navbar-nav navbar-right">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                                class="glyphicon glyphicon-user">&nbsp </span><?php echo (string)isset($user->first_name) ? $user->first_name : 'Member'; ?>
                            <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><?php echo anchor('user', '<span class="glyphicon glyphicon-tasks">&nbsp </span>Account'); ?></li>
                            <li><?php echo anchor('user/account_settings', '<span class="glyphicon glyphicon-cog">&nbsp </span>Settings'); ?></li>
                            <li class="divider"></li>
                            <li><?php echo anchor('logout', '<span class="glyphicon glyphicon-log-out">&nbsp </span>Logout'); ?></li>
                        </ul>
                    </li>
                <? else: ?>
                    <li><?php echo anchor('auth/login', 'Login <span class="glyphicon glyphicon-log-in">&nbsp </span>', 'data-toggle="modal" data-target="#login_modal"'); ?></li>
                <?endif ?>
            </ul>
        </div>
    </div>
</div>