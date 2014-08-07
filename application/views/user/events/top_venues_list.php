<? if (isset($top_venues) && !empty($top_venues)): ?>
    <?/*<? foreach ($top_venues as $venue): ?>
        <div class="row venue">
            <div class="col-md-10"><a href="#"><?= $venue->venue_name ?></a></div>
            <div class="col-md-2"><a href="#"><?= $venue->events_count ?></a></div>
        </div>
    <? endforeach ?>*/?>

    <? foreach ($top_venues as $venue): ?>
        <a href="#" class="list-group-item venue" data-venue_id="<?= $venue->id ?>">
            <span class="badge"><?= $venue->events_count ?></span>
            <h4 class="list-group-item-heading venue-name"><?= $venue->venue_name ?></h4>

            <p class="list-group-item-text venue-address"><?= $venue->venue_address ?></p>
        </a>
    <? endforeach ?>
<? endif ?>