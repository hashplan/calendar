<!--modal for event details-->
<!-- Modal -->
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <div class="modal-title" id="myModalLabel"><?=html_escape(date('l, F d', strtotime($event->event_datetime))) ?></div>
            <span class="label label-success is-my is-my-<?=$is_my ? 'shown' : 'hidden' ?>">My event</span>
            <span class="label label-primary in-calendar in-calendar-<?=$is_favourite ? 'shown' : 'hidden' ?>">In calendar</span>
            <span
                class="label label-success is-favourite is-favourite-<?=$is_favourite ? 'shown' : 'hidden' ?>">In favourites</span>
        </div>
        <div class="modal-body">
            <input type="hidden" class="google-maps-embed-api-key" value="<?=$google_maps_embed_api_key ?>"/>
            <input type="hidden" class="event-id-hidden" value="<?=urlencode($event->event_id) ?>"/>
            <input type="hidden" class="event-name-hidden" value="<?=urlencode($event->event_name) ?>"/>
            <input type="hidden" class="event-venue-hidden" value="<?=urlencode($event->venue_name) ?>"/>
            <input type="hidden" class="event-city-hidden"
                   value="<?=urlencode(($event->city_city ? $event->city_city : $event->venue_city)) ?>"/>
            <input type="hidden" class="event-address-hidden"
                   value="<?=urlencode(($event->venue_address ? $event->venue_address : $event->venue_city)) ?>"/>
            <input type="hidden" class="event-owner-id-hidden" value="<?=urlencode($event->event_owner_id) ?>"/>
            <ul class="nav nav-tabs">
                <li class="active"><a href="#event" data-toggle="tab">Overview</a></li>
                <li><a href="#venue" data-toggle="tab">Venue</a></li>
                <li><a href="#attendees" data-toggle="tab">Attendees</a></li>
            </ul>

            <div id='content' class="tab-content">
                <div class="tab-pane active" id="event">
                    <div class="row">
                        <div class="col-md-6">
                            <h4><?=html_escape($event->event_name) ?></h4>
                            <h4><?=html_escape($event->venue_name) ?></h4>
                            <h4><?=html_escape(date('H:i T', strtotime($event->event_datetime))) ?></h4>
                            <?if ($event->event_stubhub_url): ?>
                                <?=anchor('http://www.stubhub.com/' . $event->event_stubhub_url, 'Need tickets?') ?>
                            <?endif?>
                        </div>
                        <div class="col-md-6">
                            <div class="map-holder"></div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane" id="venue">
                    <div class="yelp-content-holder empty">
                    </div>
                </div>
                <div class="tab-pane" id="attendees">
                    <div class="row friends">
                        <? if (isset($friends_related_with_event) && !empty($friends_related_with_event)): ?>
                            <? foreach ($friends_related_with_event as $friendId => $friend): ?>
                                <? if ($friend['type'] == 'friend'): ?>
                                    <? $class = 'class="invite-icon invite-icon-green glyphicon glyphicon-ok"'; ?>
                                    <? $tooltip = 'Will visit!'; ?>
                                <? elseif ($friend['type'] == 'event_invite' && $friend['invited'] == $user->id): ?>
                                    <? $class = 'class="invite-icon invite-icon-blue glyphicon glyphicon-arrow-down"'; ?>
                                    <? $tooltip = 'Awaiting confirmation invitations.'; ?>
                                <?
                                elseif ($friend['type'] == 'event_invite' && $friend['invited'] != $user->id): ?>
                                    <? $class = 'class="invite-icon invite-icon-orange glyphicon glyphicon-arrow-up"'; ?>
                                    <? $tooltip = 'Invited you.'; ?>
                                <?
                                elseif ($friend['type'] == 'event_invite_declined'): ?>
                                    <? $class = 'class="invite-icon invite-icon-red glyphicon glyphicon-remove"'; ?>
                                    <? $tooltip = 'Refused the invitation.'; ?>
                                <?endif ?>
                                <div class="col-md-6 friend-related-with-event" data-uid="<?= $friendId ?>">
                                    <i <?= $class ?> title="<?= $tooltip ?>"></i>
                                    <a href="<?= site_url('user/events/' . $friendId) ?>">
                                        <img
                                            src="<?= site_url('/assets/img/' . ($friend['avatar_path'] ? 'users/' . $friend['avatar_path'] : 'icons/no-image-100.png')) ?>"/>
                                    </a>
                                    <span>
                                        <a href="<?= site_url('user/events/' . $friendId) ?>"><?= html_escape($friend['name']) ?></a>
                                    </span>
                                </div>
                            <? endforeach ?>
                        <? endif ?>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <input type="text" placeholder="Invite more friends" class="form-control"
                                   id="invite-more-friends-field" autocomplete="off">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <? if (!$in_calendar): ?>
                <button type="button" class="btn btn-primary button-add-to-calendar">Add to calendar</button>
            <? endif ?>
            <? if (!$is_favourite): ?>
                <button type="button" class="btn btn-success button-add-to-favourites">Add to favourites</button>
            <? endif ?>
            <button type="button" class="btn btn-default button-close" data-dismiss="modal" aria-hidden="true">Close</button>
        </div>
    </div>
</div>
<script id="attendees_tmpl" type="text/x-jquery-tmpl">
    <div class="col-md-6 friend-related-with-event" data-uid="${id}">
        <i class="invite-icon invite-icon-orange glyphicon glyphicon-arrow-up" title="You sent invitation."></i>
        {{if avatar_path }}
            <a href="<?= site_url('user/events') ?>/${id}">
                <img src="<?= site_url('/assets/img/users') ?>/${avatar_path}"/>
            </a>
        {{else}}
            <a href="<?= site_url('user/events') ?>/${id}">
                <img src="<?= site_url('/assets/img/icons/no-image-100.png') ?>"/>
            </a>
        {{/if}}
        <span>
            <a href="<?= site_url('user/events/') ?>/${id}">${name}</a>
        </span>
    </div>
</script>