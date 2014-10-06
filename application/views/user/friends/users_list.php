<?php foreach ($people as $dude): ?>
    <div class="panel panel-default friend-row user-<?= $dude->id ?>" data-user_id="<?= $dude->id ?>">
        <div class="panel-body">
            <div class="left-section">
                <div class="friend-pic"><img src="<?= site_url('/assets/img/' . ($dude->avatar_path ? 'users/' . $dude->avatar_path : 'icons/no-image-100.png')) ?>" class="img-circle"/></div>
            </div>
            <div class="right-section">
                <div class="friend-name"><?= $dude->name ?></div>
                <? if ($page_type === 'invites_sent'): ?>
                    <? $label_class = $dude->connection_type_full === 'Friend Request' ? 'label-success' : 'label-primary' ?>
                    <div class="connection-type-full"><span
                            class="label <?= $label_class ?>"><?= $dude->connection_type_full ?></span></div>
                <? endif ?>
                <? if ($page_type === 'invites_sent' && $dude->type === 'event_invite'): ?>
                    <div class="event-link"></div>
                <? endif ?>
                <div class="friend-mutual-count">
                    <? if ($dude->mutual_friends_count > 0): ?>
                        <?= anchor('user/friends/' . $dude->id, "<span class='glyphicon glyphicon-play'></span> " . html_escape($dude->mutual_friends_count) . " shared connections"); ?>
                    <? else: ?>
                        <?= html_escape($dude->mutual_friends_count) . " shared connections"; ?>
                    <?endif ?>
                </div>
                <div class="btn-group btn-group-xs button-wrapper">
                    <a href="<?= site_url('user/friends/remove_from_lists/' . $dude->id) ?>" class="btn btn-danger add_to_ignore_list_btn">Ignore</a>
                    <? if ($page_type === 'friends'): ?>
                        <?= anchor('user/events/' . $dude->id, 'View plans', array('class' => 'btn btn-primary friend-view-plans-button')); ?>
                    <? elseif ($page_type === 'add_friends'): ?>
                        <a href="<?= site_url('user/friends/friend_request/' . $dude->id) ?>" class="btn btn-primary friend_request_btn">Connect</a>
                    <?elseif ($page_type === 'friends_invites'): ?>
                        <?= anchor('user/friends/friend_accept/' . $dude->id, 'Connect', array('class' => 'btn btn-primary friend-view-plans-button')); ?>
                    <?elseif ($page_type === 'events_invites'): ?>
                        <?= anchor('user/friends/event_invite_accept/' . $dude->eventId, 'Connect', array('class' => 'btn btn-primary friend-view-plans-button')); ?>
                    <?endif ?>
                </div>
            </div>
        </div>
    </div>
<? endforeach ?>