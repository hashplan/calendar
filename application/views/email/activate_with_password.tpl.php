<h1><?php echo sprintf(lang('email_activate_heading'), $identity);?></h1>
<p><?php echo sprintf(lang('email_activate_subheading'), anchor('activate/'. $id .'/'. $activation, lang('email_activate_link')));?></p>
<p><strong>Password:</strong> <?=$password?></p>
<p>Please use your email to login and this password for authorization via Login form.n</p>