<?php $this->load->view('components/header'); ?>
<?php $this->load->view('user/components/header_menu') ?>
    <div class="container">
        <div class="row">
            <!--Main column-->
            <div class="col-md-9">
                <?php $this->load->view($subview); ?>
            </div>
        </div>
    </div>
<?php $this->load->view('components/footer'); ?>