<div class="container">
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <h2><?=html_escape($page_title) ?></h2>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?=$left_block ?>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-12">
                    <input type="hidden" id="friends-page-type" value="<?=$page_type ?>"/>
                    <input type="text" placeholder="Search" class="form-control" id="friends-name"/>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Friends</div>
                    </div>
                    <div id="friends-list">
                        <?=$users_list ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="panel panel-default">
                <div class="panel-heading">People you may know</div>
            </div>
            <? if (isset($people_you_may_know_block) && !empty($people_you_may_know_block)): ?>
                <div id="people-you-may-know-block">
                    <?=$people_you_may_know_block ?>
                </div>
            <? endif ?>
        </div>
    </div>
</div>