<table border="0" cellspacing="0" cellpadding="0">
    <tr>
        <td>
            <a href="<?=site_url()?>" target="_blank">
                <img src="<?= site_url('assets/img/logo/hashplan.jpg'); ?>" width="158" heigth="30" style="max-width:100%;max-height:30px;min-height:10px;min-width:10px;display:block;" alt="Hashplan logo"></a>
        </td>
    </tr>
    <tr>
        <td style="position:relative;">
            <img src="<?=site_url('assets/img/homepage/beer_garden_with_boat.jpg')?>" width="549" heigth="366"
                 style="max-width:100%;max-height:100%;min-height:10px;min-width:10px;display:block;"><a href="<?=site_url('activate/' . $id . '/' . $activation)?>" target="_blank"
                class="activate_btn"
                style="-moz-user-select: none; -ms-user-select: none; -webkit-user-select: none; background-color: #5cb85c; background-image: none; border: 1px solid transparent; border-color: #4cae4c; border-radius: 6px; bottom: 25%; color: #fff; cursor: pointer; display: inline-block; font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif; font-size: 18px; font-weight: 400; left: 25%; line-height: 1.33; margin-bottom: 0; padding: 10px 24px; position: absolute; text-align: center; text-decoration: none; user-select: none; vertical-align: middle; white-space: nowrap;">Activate
                Account</a>
        </td>
    </tr>
    <tr>
        <td>
            <div style="background-color:#f5f5f5">
                <p>
                <h3>Dear <?= sprintf(lang('email_activate_heading'), $identity); ?>,</h3>
                </p>
                <p>
                <h3>Welcome to Hashplan!</h3>
                </p>
                <p>
                    Hashplan was built for people like you who are looking for great events in their area.<br>
                    We track thousands of concerts, festivals, sporting events, and more across the U.S.
                </p>
                <p>Start making plans today and sharing them with friends! Click the button above to activate your account!</p>
            </div>
        </td>
    </tr>
</table>