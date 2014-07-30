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

$config['contact_form_email'] = 'contact@hashplans.com';
$config['from_email'] = 'noreply@hashplans.com';

$config['protocol'] = 'sendmail';
$config['mailpath'] = '/usr/sbin/sendmail';
$config['charset'] = 'utf-8';
$config['mailtype'] = 'html';
$config['newline'] = "\r\n";


/* End of file email.php */
/* Location: ./application/config/email.php */