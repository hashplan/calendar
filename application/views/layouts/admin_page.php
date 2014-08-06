<?php $this->load->view('admin/components/header_menu') ?>
<div class="container">
    <div class="row">
        <div class="col-sm-12 col-md-12 main">
            <?php $this->load->view('admin/components/counters_menu', $data) ?>

            <?php $this->load->view($view, $data) ?>
        </div>
    </div>
</div>
<!--modal for event details-->
<!-- Modal -->
<div class="modal" id="event_modal" tabindex="-1" role="dialog" aria-labelledby="event_modal" aria-hidden="true">
</div>
<!--modal for event per metro-->
<!-- Modal -->
<div class="modal" id="event_cities" tabindex="-1" role="dialog" aria-labelledby="event_cities" aria-hidden="true">
</div>
<!--modal for private event form-->
<!-- Modal -->
<div class="modal" id="user_added_event_form" tabindex="-1" role="dialog" aria-labelledby="user_added_event_form"
     aria-hidden="true">
</div>