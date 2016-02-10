<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes with
| underscores in the controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = "main";
$route['index'] = "main/index";
$route['view/(:any)'] = "main/index/$1";

$route['install'] = "install";

$route['auth'] = "auth";

$route['admin'] = "admin";
$route['admin/server/add'] = "admin_controllers/server/add";
$route['admin/server/delete'] = "admin_controllers/server/delete";

$route['admin/notification'] = "admin_controllers/notification";
$route['admin/notification/add'] = "admin_controllers/notification/add";
$route['admin/notification/edit/(:num)'] = "admin_controllers/notification/edit/$1";
$route['admin/notification/delete'] = "admin_controllers/notification/delete";

$route['admin/trigger'] = "admin_controllers/trigger";
$route['admin/trigger/add'] = "admin_controllers/trigger/add";
$route['admin/trigger/edit/(:num)'] = "admin_controllers/trigger/edit/$1";
$route['admin/trigger/delete'] = "admin_controllers/trigger/delete";

$route['server/(:num)'] = "server/index/$1";

$route['api/get/(:num)/(:any)'] = "api/serverHistory/$1/$2";

$route['404_override'] = 'error/pageNotFound';

$route['translate_uri_dashes'] = false;
