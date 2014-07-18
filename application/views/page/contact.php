
    <form action="<?= site_url('contact-us') ?>" method="POST" id="contact_form" role="form">
        <div class="form-group">
            <label class="control-label sr-only" for="user_name">Name</label>
            <input type="text" class="form-control" name="user_name" id="user_name" placeholder="Name"
                   value="<?= set_value('user_name'); ?>">
        </div>
        <div class="form-group">
            <label class="control-label sr-only" for="user_email">Email</label>
            <input type="email" class="form-control" name="user_email" id="user_email" placeholder="Email"
                   value="<?= set_value('user_email'); ?>">
        </div>
        <div class="form-group">
            <label class="control-label sr-only" for="user_name">Name</label>
            <textarea class="form-control" name="contact_description" id="contact_description" rows="3"
                      placeholder="What is troubling you?" value="<?= set_value('contact_description'); ?>"></textarea>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary btn-sm">Submit</button>
        </div>
    </form>

