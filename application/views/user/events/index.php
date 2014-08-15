<div class="metro-image" data-user_location_image="<?= isset($picture_path) && !empty($picture_path)?$picture_path:'';?>">
    
</div>


            <div class="container">
            <div class="row change-location">
            <div calss="col-md-2"></div>
                <div calss="col-md-8">
                    <h5 class="metro-name"><?=(!empty($metro_name) ? $metro_name : 'Any') ?></h5>
                    <p><?= anchor('user/events/choose_metro', 'Change Location<span class="caret"></span>', 'data-toggle="modal" data-target="#event_cities" class="metro-link"'); ?></p>
                </div>
                <div calss="col-md-2"></div>
                </div>
            <div class="row" style="margin-top: 20px;">
            <div class="col-md-2"></div>
                <div class="col-md-5" style="width: 46%!important;">
                    <input type="text" id="event_list" class="form-control" placeholder="Search for events...">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-primary" id="event-reset">Reset search</button>
                </div>
                <div class="col-md-1"></div>
            </div>
            <br>

            <div class="row">
            <div class="col-md-2"></div>
                <div class="col-md-2">
                    <label for="event-preselects">Categories</label>
                    <select name="categories" id="event-categories" class="form-control">
                        <option value="0">All</option>
                        <? foreach ($categories as $category): ?>
                            <option
                                value="<?= $category->id ?>"><?= html_escape($category->name) ?></option>
                        <? endforeach ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="event-preselects">Day Preselects</label>
                    <select name="preselects" id="event-preselects" class="form-control">
                        <option value="0">All</option>
                        <option value="7">Next 7 days</option>
                        <option value="3">Next 3 days</option>
                        <option value="weekend">Upcoming Weekend</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="hidden" name="specific_date" id="date-hidden"/>
                    <label for="event-date">Choose specific date</label>
                    <input type="text" class="form-control" id="event-date"/>
                </div>
                <div class="col-md-1"></div>
            </div>
            
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

        <div class="col-md-7 col-sm-12">

             <h2 style="display: none;" class="page-title" data-metro_name="<?=(!empty($metro_name) ? $metro_name : 'Any') ?>"><?= $page_title ?></h2>
           
            <div class="metro-id" style="display:none"><?=(!empty($metro_id) ? $metro_id : '0') ?></div>
            
            <!-- <h5>Upcoming Events:</h5> -->
            <input type="hidden" id="user-id" value="<?= $user_id ?>">
            <input type="hidden" id="events-type" value="<?= $events_type ?>">

           &nbsp;
            <div class="row">
                <div class="col-md-12" id="search_result">
                    <?= $events ?>
                </div>
            </div>
            <div class="row no-events-row <?= ($has_events ? 'hidden' : 'shown') ?>">
                <div class="col-md-12">
                    <div class="panel panel-warning">
                        <div class="panel-heading">You don't have any plans. Try to go to the "Events" and add
                            something
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-3 hidden-xs hidden-sm">
            <div class="panel panel-default widget-top-venues">
                <div class="panel-heading">
                    <div class="panel-title"><h4><strong>Top Venues</strong></h4></div>
                </div>
                <?/*<div class="panel-body">
                    <?= $top_venues; ?>
                </div>*/?>
                <div class="list-group">
                    <?= $top_venues; ?>
                </div>
            </div>
        </div>
    </div>
</div>