<div class="panel panel-default">
    <div class="panel-heading"><h2 class="sub-header">Create New Users</h2></div>
    <div class="panel-body">
        <?= validation_errors('<div class="form_error_notification errors alert alert-danger" role="alert">', '</div>') ?>
        <form action="<?= site_url('admin/users/add') ?>" method="POST" class="form-horizontal"
              role="form">
            <div class="form-group">
                <label for="first_name" class="col-md-3 control-label"><strong>First Name:</strong></label>

                <div class="col-md-9">
                    <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name"
                           value="<?= set_value('first_name') ?>">
                </div>
            </div>
            <div class="form-group">
                <label for="last_name" class="col-md-3 control-label"><strong>Last Name:</strong></label>

                <div class="col-md-9">
                    <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name"
                           value="<?= set_value('last_name') ?>">
                </div>
            </div>
            <br>

            <div class="form-group">
                <label for="email" class="col-md-3 control-label"><strong>Email:</strong></label>

                <div class="col-md-9">
                    <input type="email" class="form-control" name="email" id="email" placeholder="Email"
                           value="<?= set_value('email') ?>">
                </div>
            </div>

            <div class="form-group">
                <label for="password" class="col-md-3 control-label"><strong>Password:</strong></label>

                <div class="col-md-9">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                           value="">
                </div>
            </div>
            <div class="form-group">
                <label for="password_confirm" class="col-md-3 control-label"><strong>Confirm:</strong></label>

                <div class="col-md-9">
                    <input type="password" class="form-control" name="password_confirm" id="password_confirm"
                           placeholder="Confirm Password" value="">
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-offset-6 col-md-6 text-right">
                    <?= form_submit('submit', 'Create', 'class = "btn btn-primary"'); ?>
                    <?= anchor(site_url('admin/users'), "Cancel", 'class = "btn btn-default"'); ?>
                </div>
            </div>
        </form>
    </div>
</div>