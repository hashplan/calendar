<?foreach ($people as $friend):?>
    <div class="panel panel-default friend-row">
        <div class="panel-body">
            <div class="left-section">
                <div class="friend-pic"><img src="<?= site_url('/assets/img/icons/no-image-100.png') ?>"/></div>
            </div>
            <div class="right-section">
                <div class="friend-name"><?php echo anchor('user/events/' . $friend->id, $friend->name) ?></div>
                <?if ($page_type === 'invites_sent'): ?>
                    <? $label_class = $friend->connection_type_full === 'Friend Request' ? 'label-success' : 'label-primary' ?>
                    <div class="connection-type-full"><span
                            class="label <?= $label_class ?>"><?= $friend->connection_type_full ?></span>
                    </div>
                <? endif ?>
                <? if ($page_type === 'invites_sent' && $friend->type === 'event_invite'): ?>
                    <div class="event-link"></div>
                <? endif ?>
                <div class="friend-mutual-count">
                    <? if ($friend->mutual_friends_count > 0): ?>
                        <?= anchor('user/friends/' . $friend->id, "<span class='glyphicon glyphicon-play'></span> " . html_escape($friend->mutual_friends_count) . " shared connections"); ?>
                    <? else: ?>
                        <?= html_escape($friend->mutual_friends_count) . " shared connections"; ?>
                    <?endif ?>
                </div>
                <div class="button-wrapper">
                    <?if (isset($current_user_id)):?>
                        <?if (in_array($friend->id, $my_friends)):?>
                            <?=anchor('user/friends/remove_from_contact/' . $friend->id, 'Remove', array('class' => 'btn btn-danger'));?>
                            <?=anchor('user/events/' . $friend->id, 'View plans', array('class' => 'btn btn-primary friend-view-plans-button'));?>
                        <?else:?>
                            <?=anchor('user/friends/friend_request/' . $friend->id, 'Connect', array('class' => 'btn btn-primary friend-view-plans-button'));?>
                        <?endif?>
                    <?else:?>
                        <?=anchor('user/friends/remove_from_contact/' . $friend->id, 'Remove', array('class' => 'btn btn-danger')) ?>
                        <?if ($page_type === 'friends'):?>
                            <?=anchor('user/events/' . $friend->id, 'View plans', array('class' => 'btn btn-primary friend-view-plans-button'));?>
                        <?elseif($page_type === 'add_friends'):?>
                            <?=anchor('user/friends/friend_request/' . $friend->id, 'Connect', array('class' => 'btn btn-primary friend-view-plans-button'));?>
                        <?elseif($page_type === 'friends_invites'):?>
                            <?=anchor('user/friends/friend_accept/' . $friend->id, 'Connect', array('class' => 'btn btn-primary friend-view-plans-button'));?>
                        <?elseif($page_type === 'events_invites'):?>
                            <?=anchor('user/friends/event_invite_accept/' . $friend->eventId, 'Connect', array('class' => 'btn btn-primary friend-view-plans-button'));?>
                        <?endif?>
                    <?endif?>
                </div>
            </div>
        </div>
    </div>
<?endforeach?>