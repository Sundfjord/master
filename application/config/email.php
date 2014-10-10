<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Email
| -------------------------------------------------------------------------
| This file lets you define parameters for sending emails.
| Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/libraries/email.html
|
*/
$config['protocol'] = 'smtp';
$config['smtp_host'] = 'mailout.one.com';
$config['smtp_user'] = 'rockenroll@sundfjord.com';
$config['smtp_pass'] = 'manchesterutd1';
$config['smtp_timeout'] = '30';
$config['smtp_port'] = 25;
$config['mailtype'] = 'html';
$config['charset'] = 'utf-8';
$config['newline'] = '\r\n';
$config['crlf']    = '\r\n';


/* End of file email.php */
/* Location: ./application/config/email.php */