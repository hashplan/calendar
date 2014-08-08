<div class="container">
    <div class="row">

        <div class="col-md-2">
            <div class="thumbnail user-avatar">
                <? if ($user->avatar_path): ?>
                    <img src="<?= site_url('/assets/img/users/' . $user->avatar_path); ?>", alt="" class = "img-responsive img-rounded">
			    <? else: ?>
                    <img src="<?= site_url('/assets/img/icons/no-image-100.png'); ?>", alt="" class = "img-responsive img-rounded">
                <?endif ?>
            </div>
            <hr>
        </div>

        <div class="col-md-6">

            <h2><?= (string)$user->first_name . " " . (string)$user->last_name; ?></h2>
            <br>

            <div class="city-id" style="display:none">0</div>
            <h5 class="city-name">Location: Any</h5>

            <p><?= anchor('user/events/choose_metro', 'Change Location<span class="caret"></span>', 'data-toggle="modal" data-target="#event_cities"'); ?></p>
            <h5>Upcoming Events:</h5>
            <input type="hidden" id="user-id" value="<?= $user_id ?>">
            <input type="hidden" id="events-type" value="<?= $events_type ?>">

            <div class="row">
                <div class="col-md-8">
                    <input type="text" id="event_list" class="form-control" placeholder="Search for events...">
                </div>
                <div class="col-md-4">
                    <button type="button" class="btn btn-info" id="event-reset">Reset search</button>
                </div>
            </div>
            <br>

            <div class="row">
                <div class="col-md-4">
                    <label for="event-preselects">Categories</label>
                    <select name="categories" id="event-categories" class="form-control">
                        <option value="0">All</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= $category->id ?>"><?= html_escape($category->name) ?></option>
                        <? endforeach ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="event-preselects">Day Preselects</label>
                    <select name="preselects" id="event-preselects" class="form-control">
                        <option value="0">All</option>
                        <option value="7">Next 7 days</option>
                        <option value="3">Next 3 days</option>
                        <option value="weekend">Upcoming Weekend</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="hidden" name="specific_date" id="date-hidden"/>
                    <label for="event-date">Choose specific date</label>
                    <input type="text" class="form-control" id="event-date"/>
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
                        <div class="panel-heading">This user does not have any plans</div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-4 hidden-xs hidden-sm">
            <div class="panel panel-default widget-top-venues">
                <div class="panel-heading">
                    <div class="panel-title"><h4><strong>Top Venues (30 Days)</strong></h4></div>
                </div>
                <? /*<div class="panel-body">
                    <?= $top_venues; ?>
                </div>*/
                ?>
                <div class="list-group">
                    <?= $top_venues; ?>
                </div>
            </div>
        </div>
    </div>
</div>