<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
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
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['404_override'] = 'notfound';
$route['translate_uri_dashes'] = FALSE;


#ROUTES SYSTEM E-COMMERCE

$route["404"] = "notfound";

//  Admin
$route["admin"] = "admin";
$route["admin/dashboard"] = "admin/home/dashboard";
$route["admin/logoauth"] = "admin/home/logoauth";
$route["admin/checkAdmin"] = "admin/home/checkAdmin";

//  Users
$route["admin/users"] = "admin/home/users";
$route["admin/user"] = "admin/home/user";
$route["admin/user/(:any)"] = "admin/home/user/$1";
$route["admin/usermanager/(:any)"] = "admin/home/usermanager/$1";
$route["admin/useraddress/(:any)"] = "admin/home/useraddress/$1";
$route["admin/userremove/(:any)"] = "admin/home/userremove/$1";
$route["admin/address/(:any)"] = "admin/home/address/$1";
$route["admin/addrmanager/(:any)"] = "admin/home/addrmanager/$1";

//  Services
//$route["admin/services"] = "admin/services/index";


//FRONTEND
$route["servicos"] = "home/servicos";
$route["(:any)"] = "home/page/$1";
$route["produtos/(:any)"] = "home/produtos/$1";
$route["produto/(:any)"] = "home/produto/$1";
$route["marca/(:any)"] = "home/marca/$1";

$route["ajax/sendcontact"] = "home/ajaxcontact";