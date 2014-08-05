<div class="row placeholders">
    <div class="col-xs-6 col-sm-3 placeholder">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
             width="200px" height="200px" viewBox="0 0 200 200" xml:space="preserve" class="svg-container">
                        <circle fill="#0d8fdb" cx="100" cy="100" r="100"/>
            <a xlink:href="<?= site_url('admin/users') ?>" class="counter" text-anchor="middle">
                <? $user_count = isset($counters['users']) ? $counters['users'] : 0 ?>
                <text x="100" y="115" fill="#FFF"><?= $user_count ?></text>
            </a>
            <h4>Users</h4>
            <span class="text-muted">all members</span>
        </svg>
    </div>
    <div class="col-xs-6 col-sm-3 placeholder">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
             width="200px" height="200px" viewBox="0 0 200 200" xml:space="preserve" class="svg-container">
                        <circle fill="#39dbac" cx="100" cy="100" r="100"/>
            <a xlink:href="<?= site_url('admin/events') ?>" class="counter" text-anchor="middle">
                <? $future_events = isset($counters['future_events']) ? $counters['future_events'] : 0 ?>
                <text x="100" y="115" fill="#000"><?= $future_events ?></text>
            </a>
            <h4>Events</h4>
            <span class="text-muted">future events</span>
        </svg>
    </div>
    <div class="col-xs-6 col-sm-3 placeholder">
        <svg version="1.1" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
             width="200px" height="200px" viewBox="0 0 200 200" xml:space="preserve" class="svg-container">
                        <circle fill="#0d8fdb" cx="100" cy="100" r="100"/>
            <a xlink:href="<?= site_url('admin/events/custom') ?>" class="counter" text-anchor="middle">
                <? $custom_future_events = isset($counters['custom_future_events']) ? $counters['custom_future_events'] : 0 ?>
                <text x="100" y="115" fill="#000"><?= $custom_future_events ?></text>
            </a>
            <h4>Events</h4>
            <span class="text-muted">future custom events</span>
        </svg>
    </div>
</div>