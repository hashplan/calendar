<?php $this->load->view('admin/components/header_menu') ?>

<?php $this->load->view($view, $data) ?>

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