<div class="navbar navbar-default navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?php echo site_url('user/events'); ?>"><img src="<?php echo site_url('/assets/img/logo/hashplan_150-28.png');?>" alt="Hashplan logo"></a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="<?php echo Menu::isActive('user/events');?>"><?php echo anchor('user/events', "Profile");?></li>
                <li class="<?php echo Menu::isActive('user/events_all');?>"><?php echo anchor('user/events/all', 'Events'); ?></li>
                <li class="dropdown <?php echo Menu::isActive('user/friends');?>">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Friends <i class="caret"></i></a>
                    <ul class="dropdown-menu">
                        <li class="<?php echo Menu::isActive('user/friends/friends_current');?>"><?php echo anchor('user/friends', 'Current friends') ?></li>
                        <li class="<?php echo Menu::isActive('user/friends/friends_add');?>"><?php echo anchor('user/friends/add', 'Add friends') ?></li>
                    </ul>
                </li>
                <li class="<?php echo Menu::isActive('user/invites');?>"><?php echo anchor('user/friends/invites/', 'Invites');?></li>
            </ul>

            <!--Side bar-->
            <ul class="nav navbar-nav navbar-right">
                <li><?php echo anchor('user/events','Event Hosting');?></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user">&nbsp </span><?php echo (string)isset($user->first_name)?$user->first_name:'Member';?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><?php echo anchor('user/account_settings','<span class="glyphicon glyphicon-tasks">&nbsp </span>Account');?></li>
                        <li class="divider"></li>
                        <li><?php echo anchor('auth/logout','<span class="glyphicon glyphicon-log-out">&nbsp </span>Logout');?></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>