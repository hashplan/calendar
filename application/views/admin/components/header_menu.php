<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= site_url(''); ?>"><img src="<?= site_url('/assets/img/logo/hashplan_150-28.png'); ?>" alt="Hashplan logo"></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="<?= Menu::isActive('admin/users');?>"><a href="<?= site_url('admin/users'); ?>">Users</a></li>
                <li class="dropdown <?= Menu::isActive('admin/events/add');?> <?= Menu::isActive('admin/events/future');?> <?= Menu::isActive('admin/events/custom');?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Events <i class="caret"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= site_url('admin/events/add'); ?>"><span class="glyphicon glyphicon-plus"></span> Add New</a></li>
                        <li class="<?= Menu::isActive('admin/events/future');?>"><a href="<?= site_url('admin/events/future'); ?>">Future Events</a></li>
                        <li class="<?= Menu::isActive('admin/events/custom');?>"><a href="<?= site_url('admin/events/custom'); ?>">Custom Events</a></li>
                    </ul>
                </li>
                <li class="dropdown <?= Menu::isActive('admin/locations');?> <?= Menu::isActive('admin/events/future');?> <?= Menu::isActive('admin/events/custom');?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Locations <i class="caret"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= site_url('admin/locations'); ?>">Metroareas</a></li>
                    </ul>
                </li>
                <li class="dropdown <?= Menu::isActive('admin/venues');?> <?= Menu::isActive('admin/venues/venues_list');?> <?= Menu::isActive('admin/venues/venues_list');?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Venues <i class="caret"></i></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= site_url('admin/venues/add'); ?>"><span class="glyphicon glyphicon-plus"></span> Add New</a></li>
                        <li class="<?= Menu::isActive('admin/venues/venues_list');?>"><a href="<?= site_url('admin/venues/venues_list'); ?>">Venues</a></li>
                    </ul>
                </li>                
                <li><a href="<?= site_url('admin/crawler'); ?>">Crawler</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <? if (is_logged_in()): ?>
                    <li class="dropdown nav navbar-nav">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user">&nbsp </span><?= get_user_name() ?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <? if (is_admin()): ?>
                                <li><?= anchor('admin', '<span class="glyphicon glyphicon-eye-open">&nbsp </span>Administration'); ?></li>
                                <li class="divider"></li>
                            <?endif?>
                            <li><?= anchor('user', '<span class="glyphicon glyphicon-tasks">&nbsp </span>Account'); ?></li>
                            <li><?= anchor('user/account_settings', '<span class="glyphicon glyphicon-cog">&nbsp </span>Settings'); ?></li>
                            <li class="divider"></li>
                            <li><?= anchor('logout', '<span class="glyphicon glyphicon-log-out">&nbsp </span>Logout'); ?></li>
                        </ul>
                    </li>
                <? else: ?>
                    <li><?= anchor('login', 'Login <span class="glyphicon glyphicon-log-in">&nbsp </span>', 'data-toggle="modal" data-target="#signin_modal"'); ?></li>
                <? endif ?>
            </ul>
        </div>
    </div>
</div>