<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?=site_url(''); ?>"><img
                    src="<?=site_url('/assets/img/logo/hashplan_150-28.png'); ?>" alt="Hashplan logo"></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><?=anchor('', 'Home'); ?></li>
                <li><a href="<?=site_url('about'); ?>">About</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <? if (is_logged_in()): ?>
                    <li class="dropdown nav navbar-nav">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span
                                class="glyphicon glyphicon-user">&nbsp </span><?=(string)isset($user->first_name) ? $user->first_name : 'Member'; ?>
                            <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <li><?=anchor('user', '<span class="glyphicon glyphicon-tasks">&nbsp </span>Account'); ?></li>
                            <li><?=anchor('user/account_settings', '<span class="glyphicon glyphicon-cog">&nbsp </span>Settings'); ?></li>
                            <li class="divider"></li>
                            <li><?=anchor('logout', '<span class="glyphicon glyphicon-log-out">&nbsp </span>Logout'); ?></li>
                        </ul>
                    </li>
                <? else: ?>
                    <li><?=anchor('login', 'Login <span class="glyphicon glyphicon-log-in">&nbsp </span>', 'data-toggle="modal" data-target="#signin_modal"'); ?></li>
                <?endif ?>
            </ul>
        </div>
    </div>
</div>