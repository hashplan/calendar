<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "page";
$route['404_override'] = '';

//page
$route['about'] = "page/about";
$route['how-it-works'] = "page/howitworks";
$route['faq'] = "page/faq";
$route['contact-us'] = "page/contact_us";

//users
$route['user/events/(:num)'] = 'user/events/friends/$1';
$route['user/friends/(:num)'] = 'user/friends/mutual_friends/$1';

$route['user'] = 'user/events';
$route['user/settings'] = 'user/account_settings/index';
$route['user/settings/avatar'] = 'user/account_settings/avatar_upload';

//auth
$route['forgot_password'] = 'auth/forgot_password';
$route['reset_password/(:any)'] = 'auth/reset_password/$1';
$route['fb_login'] = 'auth/facebook_login';
$route['fb_signup'] = 'auth/facebook_login';
$route['fb_signout'] = 'auth/facebook_signout';
$route['fb_connect'] = 'auth/facebook_connect';
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';
$route['signup'] = "auth/create_user";
$route['activate/(:num)/(:any)'] = "auth/activate/$1/$2";
$route['thankyou_page'] = "auth/registration_successful";

//admin
$route['admin/users/(:num)/(:num)/(id|first_name|last_name|email|group|status)/(ASC|DESC|asc|desc)'] = 'admin/users/index/$1/$2/$3/$4';
$route['admin/users/(:num)/(:num)/(id|first_name|last_name|email|group|status)'] = 'admin/users/index/$1/$2/$3';
$route['admin/users/(:num)/(:num)'] = 'admin/users/index/$1/$2';
$route['admin/users/(:num)'] = 'admin/users/index/$1';

$route['admin/events/(:num)/(:num)'] = 'admin/events/index/$1/$2';
$route['admin/events/(:num)'] = 'admin/events/index/$1';
$route['admin/events/custom/(:num)/(:num)'] = 'admin/events/index/$1/$2';
$route['admin/events/custom/(:num)'] = 'admin/events/index/$1';

$route['admin/locations/(:num)/(:num)'] = 'admin/locations/index/$1/$2';
$route['admin/locations/(:num)'] = 'admin/locations/index/$1';
$route['admin/locations/metroarea/edit/(:num)'] = 'admin/locations/metro_edit/$1';
$route['admin/locations/metroarea/remove/(:num)'] = 'admin/locations/metro_remove/$1';

$route['admin'] = 'admin/dashboard/index';



/* End of file routes.php */
/* Location: ./application/config/routes.php */