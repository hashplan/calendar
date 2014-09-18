<div class="container">
    <div class="row">

        <div class="col-md-2 col-sm-12">
            <div class="thumbnail user-avatar">
                <? if ($user->avatar_path): ?>
                    <img src="<?= site_url('/assets/img/users/' . $user->avatar_path); ?>", alt="" class = "img-responsive img-rounded">
			    <? else: ?>
                    <img src="<?= site_url('/assets/img/icons/no-image-100.png'); ?>", alt="" class = "img-responsive img-rounded">
                <?endif ?>
            </div>
            <hr>
            <!-- Single button -->
            <?= anchor('event/add', "ADD EVENT", 'class = "btn btn-primary btn-block" data-toggle = "modal" data-target = "#user_added_event_form"'); ?>
            <?= anchor('user/events/favourite', "<span class='glyphicon glyphicon-thumbs-up'> &nbsp</span>Favourites", 'class = "btn btn-default btn-block button-favourites ' . Menu::isActive('user/events/favourite') . '"'); ?>
            <?= anchor('user/events/trash', "<span class='glyphicon glyphicon-trash'> &nbsp</span>Trash", 'class = "btn btn-default btn-block button-trash ' . Menu::isActive('user/events/trash') . '"'); ?>
        </div>

        <div class="col-md-9 col-sm-12">

            <h2 class="page-title" data-metro_name="<?=(!empty($metro_name) ? $metro_name : 'Any') ?>"><?= $page_title ?></h2>
            <input type="hidden" id="user-id" value="<?= $user_id ?>">
            <input type="hidden" id="events-type" value="<?= $events_type ?>">

            <div class="row">
                <div class="col-md-8">
                    <input type="text" id="event_list" class="form-control" placeholder="Yankees, U2, thursday, stadium...">
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-primary" id="event-reset">Reset search</button>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-md-4">
                    <select name="categories" id="event-categories" class="form-control">
                        <option value="0">All Categories</option>
                        <? foreach ($categories as $category): ?>
                            <option
                                value="<?= $category->id ?>"><?= html_escape($category->name) ?></option>
                        <? endforeach ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="preselects" id="event-preselects" class="form-control">
                        <option value="0">All Day Preselects</option>
                        <option value="7">Next 7 days</option>
                        <option value="3">Next 3 days</option>
                        <option value="weekend">Upcoming Weekend</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="hidden" name="specific_date" id="date-hidden"/>
                    <input type="text" class="form-control" id="event-date" value = "Pick Date"/>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12" id="search_result">
                    <?= $events ?>
                </div>
            </div>
            <div class="row no-events-row <?= ($has_events ? 'hidden' : 'shown') ?>">
                <div class="col-md-12">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            <?if($events_type == 'deleted'):?>
                                Your ignore list is empty
                            <?elseif($events_type == 'favourite'):?>
                                Your favorite list is empty
                            <?else:?>
                                You don't have any plans. Try to go to the "Events" and add something fun
                            <?endif?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>