<?foreach($people as $dude):?>
    <div class="panel panel-default friend-row user-<?= $dude->id ?>" data-user_id="<?= $dude->id ?>">
        <div class="panel-body">
            <div class="left-section">
                <div class="friend-pic"><img src="/assets/img/icons/no-image-100.png"/></div>
            </div>
            <div class="right-section">
                <div class="friend-name"><?= $dude->name ?></div>
                <?if ($page_type === 'invites_sent'):?>
                    <?$label_class = $dude->connection_type_full === 'Friend Request' ? 'label-success' : 'label-primary'?>
                    <div class="connection-type-full"><span class="label <?= $label_class ?>"><?= $dude->connection_type_full ?></span></div>
                <?endif?>
                <?if ($page_type === 'invites_sent' && $dude->type === 'event_invite'):?>
                    <div class="event-link"></div>
                <?endif?>
                <div class="friend-mutual-count">
                    <?if($dude->mutual_friends_count > 0):?>
                        <?= anchor('user/friends/'. $dude->id, "<span class='glyphicon glyphicon-play'></span> ". html_escape($dude->mutual_friends_count). " shared connections");?>
                    <?else:?>
                        <?=html_escape($dude->mutual_friends_count) ." shared connections";?>
                    <?endif?>
                </div>
                <div class="button-wrapper">
                    <?if(in_array($dude->id, $my_friends)):?>
                        <a href="<?=site_url('user/friends/remove_from_contact/' . $dude->id)?>" class="btn btn-danger remove_from_friendlist_btn">Remove</a>
                        <?=anchor('user/events/'. $dude->id, 'View plans', array('class' => 'btn btn-primary friend-view-plans-button'));?>
                    <?else:?>
                        <?=anchor('user/friends/friend_request/'. $dude->id, 'Connect', array('class' => 'btn btn-primary friend-view-plans-button'));?>
                    <?endif?>
                </div>
            </div>
        </div>
    </div>
<?endforeach?>