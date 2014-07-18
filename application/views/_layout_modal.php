<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3><?=$modal_header?></h3>

            <p class="<?=$page_class?>-form-errors form_error"></p>
        </div>
        <div class="modal-body">
            <? $this->load->view($view); ?>
        </div>
    </div>
</div>