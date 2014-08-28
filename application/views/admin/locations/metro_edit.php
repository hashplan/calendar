<div class="panel panel-default">
    
    <div class="panel-heading"><h2 class="sub-header"><?=$title?></h2></div>
    <div class="panel-body">
        <?= validation_errors('<div class="form_error_notification errors alert alert-danger" role="alert">', '</div>') ?>
            <form action="<?= site_url('admin/locations/metro_edit/' . (isset($metro->id) &&!empty($metro->id) ? $metro->id:'')); ?>" method="POST" class="form-horizontal edit-metroarea-form"
              enctype="multipart/form-data" role="form">
            <div class="" id="metroarea-upload">
                <h4>Change Metroarea picture:</h4>
                <div class="thumbnail user-avatar">
                    <? if (isset($metro->picture_path) && !empty($metro->picture_path)): ?>
                        <img src="<?php echo site_url('/assets/img/metroareas/' . $metro->picture_path); ?>" alt=""
                             class="img-responsive img-rounded">
                    <? else: ?>
                        <img src="<?php echo site_url('/assets/img/icons/no-image-100.png'); ?>" alt=""
                             class="img-responsive img-rounded">
                    <?endif ?>
                </div>
                <div id="uploader-file-selector" class="pull-right">

                        <input type="hidden" name="metro_id" value="<?= isset($metro->id) &&!empty($metro->id) ? $metro->id:'';?>"/>
                        <div class="form-group">
                            <label for="metroareafile" class="sr-only">Metroarea Picture</label>
                            <input id="metroareafile" type="file" name="metroareafile" value="">
                        </div>
                        
                </div>
            </div>
        
            <div class="form-group">
                <label for="city" class="col-md-4 col-sm-2 control-label"><strong>Name:</strong></label>

                <div class="col-md-6 col-sm-12">
                    <input type="text" class="form-control" name="city" id="city" placeholder="Metroarea name"
                           value="<?= set_value('city', $metro->city) ?>">
                </div>
            </div>
            <? if (isset($states) && !empty($states)): ?>
                <hr>
                <div class="form-group">
                    <label for="state" class="col-md-4 col-sm-2 control-label"><strong>State:</strong></label>

                    <div class="col-md-6 col-sm-12">
                        <div class="input-group">
                            <select name="state_id" class="form-control state" id="state">
                                <? foreach ($states as $state): ?>
                                    <option value="<?= $state->id ?>" <?=set_select('state', $state->id, $state->id == $metro->state_id)?>><?= html_escape($state->state) ?></option>
                                <? endforeach ?>
                            </select>

                            <? if (isset($countries) && !empty($countries)): ?>
                                <span class="input-group-btn">
                                    <select class="country btn" id="country_filter">
                                        <? foreach ($countries as $country): ?>
                                            <option value="<?= $country->id ?>" <?=set_select('state', $country->id, $country->id == $metro->country_id)?>><?= html_escape($country->country) ?></option>
                                        <? endforeach ?>
                                    </select>
                                </span>
                            <? endif ?>

                        </div>
                    </div>
                </div>
            <? endif ?>
            <div class="form-group">
                <label for="pollstar_id" class="col-md-4 col-sm-2 control-label"><strong>Pollstar Id:</strong></label>

                <div class="col-md-6 col-sm-12">
                    <input type="text" class="form-control" name="pollstar_id" id="pollstar_id" placeholder="Pollstar Id"
                           value="<?= set_value('pollstar_id', $metro->pollstar_id) ?>">
                </div>
            </div>

            <hr>
            <div class="row">
                <div class="col-md-offset-6 col-md-6 text-right">
                    <?= form_submit('submit', 'Update', 'class = "btn btn-primary"'); ?>
                    <?= anchor(site_url('admin/locations'), "Cancel", 'class = "btn btn-default"'); ?>
                </div>
            </div>
        </form>
    </div>
</div>