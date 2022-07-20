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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


//$routes->group('admin', static function ($routes) {
//
//	$routes->get('login', 'Admin\AdminController::login',['as' => 'admin.login']);
//	$routes->get('dashboard', 'Admin\AdminController::dashboard',['as' => 'admin.dashboard']);
//
////    $routes->group('users', static function ($routes) {
////        $routes->get('list', 'Admin\Users::list');
////    });
//
//
//});



/**
 * ROUTE ADDRESS
 * LISTED BELOW
 */

$route['admin'] = 'admin/accountController';
$route['admin/login'] = 'admin/accountController/login';

$route['api/customer/create'] = 'api/customerApi/create';

//$route['admin/login'] = 'admin/account/login';


// API ROUTES
// SELLER
$route['api/seller/get-all'] ['GET'] = 'api/sellerApi/index';
$route['api/seller/details'] ['GET'] = 'api/sellerApi/getDetails';
$route['api/seller/login']['POST'] = 'api/sellerApi/login';
$route['api/seller/register']['POST'] = 'api/sellerApi/register';

// CUSTOMER
$route['api/customer/get-all'] ['GET'] = 'api/customerApi/index';
$route['api/customer/login']['POST'] = 'api/customerApi/login';
$route['api/customer/register']['POST'] = 'api/customerApi/register';
$route['api/customer/get']['GET'] = 'api/customerApi/getDetails';
$route['api/customer/change-password']['POST'] = 'api/customerApi/changePassword';

// Customer Application Portal
$route['api/customer/get-homepage'] ['get'] = 'api/customerHome/index';
$route['api/customer/my-reward'] ['get'] = 'api/customerHome/getMyRewards';
$route['api/customer/order-fuel'] ['post'] = 'api/customerHome/placeFuelOrder';


// VEHICLE
$route['api/vehicle/get']['GET'] = 'api/customerApi/getVehicleDetails';

// GIFT
$route['api/gifts/all']['GET'] = 'api/giftApi/index';
//Foods
$route['api/foods/all']['GET'] = 'api/foodApi/index';

// Fuel

$route['api/fuel/today'] ['GET'] = 'api/fuelApi/todayRate';
