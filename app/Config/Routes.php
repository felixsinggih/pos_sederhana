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
$routes->setDefaultController('Login');
$routes->setDefaultMethod('index');
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
$routes->get('/', 'Login::index', ['filter' => 'noauth']);
$routes->match(['get', 'post'], '/login', 'Login::masuk', ['filter' => 'noauth']);
$routes->get('/logout', 'Login::keluar', ['filter' => 'auth']);

$routes->get('/dashboard', 'Dashboard::index', ['filter' => 'auth']);

$routes->get('/users', 'Users::index', ['filter' => 'auth']);
$routes->get('/users/add', 'Users::tambah', ['filter' => 'auth']);
$routes->post('/users/save', 'Users::simpan', ['filter' => 'auth']);
$routes->get('/users/(:segment)', 'Users::detail/$1', ['filter' => 'auth']);
$routes->get('/users/edit/(:segment)', 'Users::ubah/$1', ['filter' => 'auth']);
$routes->post('/users/update/(:segment)', 'Users::ubah_data/$1', ['filter' => 'auth']);
$routes->post('/users/searching', 'Users::pencarian', ['filter' => 'auth']);
$routes->get('/users/search/(:segment)', 'Users::cari/$1', ['filter' => 'auth']);

$routes->get('/product', 'Product::index', ['filter' => 'auth']);
$routes->get('/product/add', 'Product::tambah', ['filter' => 'auth']);
$routes->post('/product/save', 'Product::simpan', ['filter' => 'auth']);
$routes->get('/product/(:segment)', 'Product::detail/$1', ['filter' => 'auth']);
$routes->get('/product/edit/(:segment)', 'Product::ubah/$1', ['filter' => 'auth']);
$routes->post('/product/update/(:segment)', 'Product::ubah_data/$1', ['filter' => 'auth']);
$routes->post('/product/searching', 'Product::pencarian', ['filter' => 'auth']);
$routes->get('/product/search/(:segment)', 'Product::cari/$1', ['filter' => 'auth']);

$routes->get('/sales', 'Penjualan::index', ['filter' => 'auth']);
$routes->post('/sales/searching', 'Penjualan::pencarian', ['filter' => 'auth']);
$routes->get('/sales/search/(:segment)', 'Penjualan::cari/$1', ['filter' => 'auth']);
$routes->get('/cart', 'Penjualan::transaksi', ['filter' => 'auth']);
$routes->get('/cart/product', 'Penjualan::data_produk');
$routes->post('/cart/add', 'Penjualan::tambah_produk', ['filter' => 'auth']);
$routes->post('/cart/edit', 'Penjualan::edit_produk', ['filter' => 'auth']);
$routes->get('/cart/delete/(:any)', 'Penjualan::hapus_produk/$1', ['filter' => 'auth']);
$routes->get('/cart/clear', 'Penjualan::hapus_cart', ['filter' => 'auth']);
$routes->post('/cart/save', 'Penjualan::simpan', ['filter' => 'auth']);
$routes->get('/sales/(:segment)', 'Penjualan::detail/$1', ['filter' => 'auth']);
$routes->get('/sales/print/(:segment)', 'Penjualan::print/$1', ['filter' => 'auth']);

$routes->get('/report', 'Laporan::index', ['filter' => 'auth']);
$routes->post('/report', 'Laporan::index', ['filter' => 'auth']);
$routes->get('/report/day/(:segment)', 'Laporan::cetak_hari/$1', ['filter' => 'auth']);
$routes->get('/report/print/(:segment)/(:segment)', 'Laporan::cetak/$1/$2', ['filter' => 'auth']);
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
