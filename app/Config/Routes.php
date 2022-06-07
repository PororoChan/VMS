<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

//Page
$routes->get('', 'Home::index');
$routes->add('register', 'Login::index1');
$routes->add('login', 'Login::index');
$routes->add('cekLogin', 'Login::cek');
$routes->add('register1', 'Login::simpan');
$routes->add('logout', 'Login::logout');

$routes->add('usergroup', 'master\Usergroup::index');
$routes->add('menu', 'master\Menu::index');
$routes->add('user', 'master\User::index');
$routes->add('msuser', 'master\UserDetail::index');
$routes->add('brand', 'master\Brand::index');
$routes->add('branch', 'master\Branch::index');
$routes->add('convers', 'master\Conversion::index');
$routes->add('customer', 'master\Customer::index'); // tabel vmsmscustomer 404
$routes->add('area', 'master\Area::index'); // tabel vmsmsareacode 404
$routes->add('alias', 'master\Alias::index'); // tabel vmsmsaliascode 404
$routes->add('schedule', 'master\Schedule::index'); // tabel vmsmsschedule 404

/** MODAL FORM **/
//Usergroup
$routes->add('usergroup/AddViews', 'master\Usergroup::FormViews');
$routes->add('usergroup/EditViews/(:num)', 'master\Usergroup::FormViews/$1');
$routes->add('usergroup/AccessViews/(:num)', 'master\Usergroup::AccessViews/$1');
//Master Menu
$routes->add('menu/AddViews', 'master\Menu::FormViews');
$routes->add('menu/EditViews/(:num)/(:num)', 'master\Menu::FormViews/$1/$2');
// Brand
$routes->add('brand/AddViews', 'master\Brand::FormViews');
$routes->add('brand/EditViews/(:any)', 'master\Brand::FormViews/$1');
//Branch
$routes->add('branch/AddViews', 'master\Branch::FormViews');
$routes->add('branch/EditViews/(:any)', 'master\Branch::FormViews/$1');
//Area
$routes->add('area/AddViews', 'master\Area::FormViews');
$routes->add('area/EditViews/(:any)', 'master\Area::FormViews/$1');
//Alias
$routes->add('alias/AddViews', 'master\Alias::FormViews');
$routes->add('alias/EditViews/(:any)', 'master\Alias::FormViews/$1');
//Schedule
$routes->add('schedule/AddViews', 'master\Schedule::FormViews');
$routes->add('schedule/EditViews/(:any)', 'master\Schedule::FormViews/$1');
//Customer
$routes->add('customer/AddViews', 'master\Customer::FormViews');
$routes->add('customer/EditViews/(:any)', 'master\Customer::FormViews/$1');
//User
$routes->add('user/FormViews', 'master\User::FormViews');
$routes->add('user/EditViews/(:num)', 'master\User::FormViews/$1');
$routes->add('userdetail/FormViews', 'master\Userdetail::FormViews');
$routes->add('userdetail/EditViews/(:num)', 'master\Userdetail::FormViews/$1');
$routes->add('user/Accessgroup/(:num)', 'master\User::Accessgroup/$1');
//UserDetail
$routes->add('userdetail/FormViews', 'master\UserDetail::FormViews');
$routes->add('userdetail/EditViews/(:any)', 'master\UserDetail::FormViews/$1');
//Conversions
$routes->add('convers/FormViews', 'master\Conversion::FormViews');


/**END MODAL FORM **/

/** SUBMIT FORM **/
//Usergroup
$routes->add('usergroup/addData', 'master\Usergroup::addData');
$routes->add('usergroup/editData', 'master\Usergroup::editData');
$routes->add('usergroup/deleteData', 'master\Usergroup::deleteData');
$routes->add('usergroup/accessData', 'master\Usergroup::accessData');

//Master Menu
$routes->add('menu/addData', 'master\Menu::addData');
$routes->add('menu/editData', 'master\Menu::editData');
$routes->add('menu/deleteData', 'master\Menu::deleteData');

// Brand Menu
$routes->add('brand/addBrand', 'master\Brand::addBrand');
$routes->add('brand/editBrand', 'master\Brand::editBrand');
$routes->add('brand/deleteBrand', 'master\Brand::deleteBrand');

//Branch Menu
$routes->add('branch/addData', 'master\Branch::addData');
$routes->add('branch/editData', 'master\Branch::editData');
$routes->add('branch/deleteData', 'master\Branch::deleteData');

//Area Menu
$routes->add('area/addData', 'master\Area::addData');
$routes->add('area/editData', 'master\Area::editData');
$routes->add('area/deleteData', 'master\Area::deleteData');

//Alias Menu
$routes->add('alias/addData', 'master\Alias::addData');
$routes->add('alias/editData', 'master\Alias::editData');
$routes->add('alias/deleteData', 'master\Alias::deleteData');

//Schedule Menu
$routes->add('schedule/addData', 'master\Schedule::addData');
$routes->add('schedule/editData', 'master\Schedule::editData');
$routes->add('schedule/deleteData', 'master\Schedule::deleteData');

//Customer Menu
$routes->add('customer/addData', 'master\Customer::addData');
$routes->add('customer/editData', 'master\Customer::editData');
$routes->add('customer/deleteData', 'master\Customer::deleteData');

//User
$routes->add('user/addData', 'master\User::addData');
$routes->add('user/editData', 'master\User::editData');
$routes->add('user/deleteData', 'master\User::deleteData');
$routes->add('user/resetData', 'master\User::resetData');
$routes->add('user/accessData', 'master\User::Addaccessgroup');
$routes->add('user/deleteaccessData', 'master\User::deleteaccessgroup');
$routes->add('user/editaccessData', 'master\User::Editaccessgroup');

// UserDetail
$routes->add('userdetail/addData', 'master\UserDetail::addData');
$routes->add('userdetail/editData', 'master\UserDetail::editData');
$routes->add('userdetail/deleteData', 'master\UserDetail::deleteData');

/** END SUBMIT FORM **/

//Datatabel
$routes->add('usergroup/datatabel', 'master\Usergroup::datatabel');
$routes->add('msuser/datatabel', 'master\UserDetail::datatabel');
$routes->add('menu/datatabel', 'master\Menu::datatabel');
$routes->add('user/datatabel', 'master\User::datatabel');
$routes->add('branch/datatabel', 'master\Branch::datatabel');
$routes->add('brand/datatabel', 'master\Brand::datatabel');
$routes->add('convers/datatabel', 'master\Conversion::datatabel');
$routes->add('branch/datatabel/(:any)', 'master\Branch::datatabel/$1');
$routes->add('customer/datatabel', 'master\Customer::datatabel');
$routes->add('customer/datatabel/(:any)', 'master\Customer::datatabel/$1');
$routes->add('area/datatabel', 'master\Area::datatabel');
$routes->add('alias/datatabel', 'master\Alias::datatabel');
$routes->add('schedule/datatabel', 'master\Schedule::datatabel');
$routes->add('user/grouptableaccess/(:num)', 'master\User::GroupAccessTable/$1');
//Select2
$routes->add('menu/getMaster', 'master\Menu::getMaster');
$routes->add('user/getGroup', 'master\User::getGroup');
$routes->add('userdetail/getUser', 'master\UserDetail::getUser');
$routes->add('user/getKas', 'master\User::getKasacabid');
$routes->add('user/getSpv', 'master\User::getSpv');
$routes->add('alias/getAlias', 'master\Alias::getAlias');
$routes->add('area/getArea', 'master\Area::getArea');
$routes->add('branch/getBranch', 'master\Branch::getBranch');
$routes->add('customer/getCustomer', 'master\Customer::getCustomer');

//Other

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
