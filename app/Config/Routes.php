<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
    require SYSTEMPATH . 'Config/Routes.php';
}
  
/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */ 
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/* 
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->group("/",['filter'=>'Guest'], function($routes){
    $routes->get('login', 'LoginController::login');
    $routes->get('register', 'LoginController::register');
    $routes->post('register', 'LoginController::create');
    $routes->post('loginUser', 'LoginController::verify');   
});
 
  
$routes->group("user",['filter'=>'LoggedinCheck'], function($routes){
    $routes->get('/', 'UserProfilePage::index');
    $routes->get('profile', 'UserProfilePage::profile');
    $routes->get('getcountry', 'UserProfilePage::getcountry'); 
    $routes->post('updatephoto', 'UserProfilePage::updatephoto');
    $routes->post('getstate', 'UserProfilePage::getstate'); 
    $routes->post('getcity', 'UserProfilePage::getcity'); 
    $routes->post('updateName', 'UserProfilePage::updateName'); 
    $routes->post('updateEmail', 'UserProfilePage::updateEmail');
    $routes->post('updatePhone', 'UserProfilePage::updatePhone');
    $routes->post('updatePassword', 'UserProfilePage::updatePassword');
    $routes->post('updateAddress', 'UserProfilePage::updateAddress'); 
    $routes->get('addnew', 'PostController::index'); 
    $routes->post('createPost', 'PostController::createPost');
    $routes->get('userPost', 'PostController::viewpost');
    $routes->get('sendmail', 'EmailController::index'); 
    $routes->post('sendemails', 'EmailController::send'); 
    $routes->get('userlogout', 'LoginController::logout');
});
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
