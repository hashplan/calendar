<? foreach ($events as $event): ?>
    <div class="panel panel-default friend-row event-<?= $event['event_id'] ?>" data-event_id="<?= $event['event_id'] ?>">
        <div class="panel-body">
            <div class="row">
                <div class="col-md-7 col-sm-12">
                    <p class="event-name"><?= anchor('event/modal_details/' . $event['event_id'], $event['event_name'], 'data-toggle="modal" data-target="#event_modal"'); ?></p>
                    <p class="event-venue"><?= $event['vanue_name'] ?></p>
                    <p class="event-venue"><?= $event['datetime'] ?></p>
                </div>
                <div class="col-md-5 col-sm-12">
                    <div class="hidden-lg hidden-md text-left">
                        <a href="<?= site_url('user/friends/event_invitation_accept/' . $event['event_id']) ?>" class="btn btn-primary event_accept_invitation_btn">Accept</a> 
                        <a href="<?= site_url('user/friends/event_invitation_cancelled/' . $event['event_id']) ?>" class="btn btn-danger event_cancel_invitation_btn">Cancel</a> 
                    </div>
                    <div class="hidden-xs hidden-sm text-right">
                        <a href="<?= site_url('user/friends/event_invitation_accept/' . $event['event_id']) ?>" class="btn btn-primary event_accept_invitation_btn">Accept</a> 
                        <a href="<?= site_url('user/friends/event_invitation_cancelled/' . $event['event_id']) ?>" class="btn btn-danger event_cancel_invitation_btn">Cancel</a> 
                    </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <?if(!empty($event['users'])):?>
                    <? foreach ($event['users'] as $user): ?>
                        <div class="friend-pic col-md-2">
                            <a href="<?= site_url('user/events/' . $user['uid']) ?>">
                                <img src="<?= site_url('/assets/img/' . ($user['avatar_path'] ? 'users/' . $user['avatar_path'] : 'icons/no-image-100.png')) ?>" title="<?= $user['user_name'] ?>" class="img-circle"/>
                            </a>
                        </div>
						<div class = "col-md-4">
							<a href="<?= site_url('user/events/' . $user['uid']) ?>">
								<?= $user['user_name'] ?>
							</a>
						</div>
                    <? endforeach ?>
                <?endif?>
            </div>
        </div>
    </div>
<? endforeach ?>