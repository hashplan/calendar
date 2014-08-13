<table border="0" cellspacing="0" cellpadding="0" width="549px" bgcolor="#ffffff" style="font-family: 'Helvetica Neue',Helvetica,Arial,sans-serif;">
    <tr>
        <td style="padding: 20px 30px 100px 30px;">
            <div>
                <p><h3><?php echo sprintf(lang('email_forgot_password_heading'), $identity); ?></h3></p>
                <p><?php echo sprintf(lang('email_forgot_password_subheading'), anchor('reset_password/' . $forgotten_password_code, lang('email_forgot_password_link'))); ?></p>
            </div>
        </td>
    </tr>
</table>