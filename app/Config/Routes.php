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
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
if (!env('isMaintenance')) {
	$routes->get('/', 'DefaultController::index', ['as' => 'home']);
	$routes->get('about', 'DefaultController::about', ['as' => 'about']);
	$routes->get('artikel/(:segment)', 'DefaultController::artikel/$1', ['as' => 'detail.artikel']);
	$routes->post('artikel', "DefaultController::handleCommentCreate", ['as' => 'handle.comment']);
	//$routes->get('debug/(:segment)', "AdminController::getEncrypted/$1");

	$routes->group('admin', function ($routes) {
		$routes->get('/', 'AdminController::showLogin', ['as' => 'admin.login']);
		$routes->post('login', 'AdminController::loginProcess', ['as' => 'admin.login.process']);
		$routes->post('logout', 'AdminController::logoutProcess', ['as' => 'admin.logout.process']);
		$routes->group('artikel', function ($routes) {
			$routes->get('/', 'AdminController::manageArticle', ['as' => 'admin.artikel']);
			$routes->get('create', 'AdminController::articleCreate', ['as' => 'admin.artikel.create']);
			$routes->post('create', 'AdminController::articleCreateProcess', ['as' => 'admin.artikel.create.process']);
			$routes->get('edit/(:num)', 'AdminController::articleEdit/$1', ['as' => 'admin.artikel.edit']);
			$routes->post('edit/(:num)', 'AdminController::articleEditProcess/$1', ['as' => 'admin.artikel.edit.process']);
			$routes->post('delete/(:num)', 'AdminController::articleDeleteProcess/$1', ['as' => 'admin.artikel.delete.process']);
			if (env('enableComment')) {
				$routes->group('comment', function ($routes) {
					$routes->get('(:num)', 'CommentController::index/$1', ['as' => 'admin.artikel.comment']);
					$routes->post('ajax', 'CommentController::kelolaAJAX');
					$routes->post('edit', 'CommentController::editComment', ['as' => 'admin.artikel.comment.edit']);
				});
			}
		});
		$routes->post('ajax', 'AdminController::kelolaAJAX');
		$routes->group('kategori', function ($routes) {
			$routes->get('/', 'AdminController::manageKategori', ['as' => 'admin.kategori']);
			$routes->post('create', 'AdminController::kategoriCreateProcess', ['as' => 'admin.kategori.create.process']);
			$routes->post('edit', 'AdminController::kategoriEditProcess', ['as' => 'admin.kategori.edit.process']);
			$routes->post('delete', 'AdminController::kategoriDeleteProcess', ['as' => 'admin.kategori.delete.process']);
		});
		$routes->group('user', function ($routes) {
			$routes->post('changepass', 'UserController::changePassword', ['as' => 'admin.user.changepass']);
			$routes->get('/', 'UserController::manageUser', ['as' => 'admin.user.manage']);
			$routes->post('create', 'UserController::createUser', ['as' => 'admin.user.create']);
			$routes->post('edit', 'UserController::editUser', ['as' => 'admin.user.edit']);
			$routes->post('delete', 'UserController::deleteUser', ['as' => 'admin.user.delete']);
			$routes->post('ajax', 'UserController::kelolaAJAX');
		});
	});
} else {
	$routes->get('/', 'MaintenanceController::index');
}


/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need to it be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
