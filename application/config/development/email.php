<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Email
| -------------------------------------------------------------------------
| This file lets you define parameters for sending emails.
| Please see the user guide for info:
|
| http://ellislab.com/codeigniter/user-guide/libraries/email.html
|
*/
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'ssl://smtp.gmail.com.';
$config['smtp_port'] = '465';
$config['smtp_user'] = 'hashplans@gmail.com';
$config['smtp_pass'] = 'Hashplans0514';
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = "\r\n";

$config['contact_form_email'] = 'hashplans@gmail.com';
$config['from_email'] = 'hashplans@gmail.com';

/* End of file email.php */
/* Location: ./application/config/email.php */