<?php foreach ($people_you_may_know as $dude): ?>
    <div class="row">
        <div class="col-md-12">
            <input type="hidden" class="dude-id" value="<?= html_escape($dude->id) ?>"/>
            <div class="left-section">
                <div class="dude-pic"><img src="<?= site_url('/assets/img/' . ($dude->avatar_path ? 'users/' . $dude->avatar_path : 'icons/no-image-100.png')) ?>" class="img-circle"/></div>
            </div>
            <div class="right-section">
                <div class="dude-name">
                    <?= html_escape($dude->name) ?>
                    <br>
                    <a href="<?=site_url('user/friends/friend_request/' . $dude->id)?>" class="connect-link"><i class="glyphicon glyphicon-plus-sign"></i> Connect</a>
                </div>
            </div>
            <a href="<?= site_url('user/friends/remove_from_lists/' . $dude->id) ?>" class="remove-from-lists-link"><i class="glyphicon glyphicon-remove"></i></a>
        </div>
    </div>
<? endforeach ?>