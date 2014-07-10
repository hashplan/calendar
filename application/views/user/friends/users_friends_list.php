<?php foreach($people as $dude) {?>
    <div class="panel panel-default friend-row">
        <div class="panel-body">
            <div class="left-section">
                <div class="friend-pic"><img src="/assets/img/icons/no-image-100.png"/></div>
            </div>
            <div class="right-section">
                <div class="friend-name"><?php echo anchor('user/events/'. $dude->id, $dude->name) ?></div>
                <?php if ($page_type === 'invites_sent') {
                    $label_class = $dude->connection_type_full === 'Friend Request' ? 'label-success' : 'label-primary'?>
                    <div class="connection-type-full"><span class="label <?php echo $label_class ?>"><?php echo $dude->connection_type_full ?></span></div>
                <?php } ?>
                <?php if ($page_type === 'invites_sent' && $dude->type === 'event_invite') { ?>
                    <div class="event-link">
                    </div>
                <?php } ?>
                <div class="friend-mutual-count">
                    <?php if($dude->mutual_friends_count > 0){
                        echo anchor('user/friends/'. $dude->id, "<span class='glyphicon glyphicon-play'></span> ". html_escape($dude->mutual_friends_count). " shared connections");
                    }
                    else{
                        echo html_escape($dude->mutual_friends_count) ." shared connections";
                    }?>

                </div>
                <div class="button-wrapper">
                    <?php if(in_array($dude->id, $my_friends)){
                        echo anchor('user/friends/remove_from_contact/'. $dude->id, 'Remove', array('class' => 'btn btn-danger'));
                        echo anchor('user/events/'. $dude->id, 'View plans', array('class' => 'btn btn-primary friend-view-plans-button'));
                    }else{
                        echo anchor('user/friends/friend_request/'. $dude->id, 'Connect', array('class' => 'btn btn-primary friend-view-plans-button'));
                    }?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>