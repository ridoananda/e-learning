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
$routes->setDefaultController('Atuh');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Pages::index');
$routes->get('/artikel', 'Pages::artikel');
$routes->get('/users/(:any)', 'Pages::users/$1');
$routes->post('/artikel', 'Pages::artikel');
$routes->post('/laporan', 'Pages::laporan');
$routes->post('/hubungi', 'Pages::hubungi');
$routes->get('/artikel/(:segment)', 'Pages::detail_artikel/$1');
$routes->post('/add-komentar', 'Pages::add_komentar');
$routes->get('/masuk', 'Auth::masuk');
$routes->get('/daftar', 'Auth::daftar');

// APLIKASI
$routes->group('aplikasi', function ($routes) {

	$routes->get('/', 'Aplikasi\Aplikasi::index');
	$routes->get('menu', 'Aplikasi\Menu::index');

	// SISWA
	$routes->group('siswa', function ($routes) {
		$routes->get('/', 'Aplikasi\Siswa::index');
		$routes->get('forum-tugas', 'Aplikasi\Siswa::forum_tugas');
		$routes->get('detail-tugas/(:num)', 'Aplikasi\Siswa::detail_tugas/$1');
		$routes->put('tambah-komentar', 'Aplikasi\Siswa::tambah_komentar');
	});

	// GURU
	$routes->group('guru', function ($routes) {
		$routes->get('/', 'Aplikasi\Guru::index');
		$routes->get('forum-tugas', 'Aplikasi\Guru::forum_tugas');
		$routes->get('detail-tugas/(:num)', 'Aplikasi\Guru::detail_tugas/$1');
		$routes->get('data-absen/(:num)', 'Aplikasi\Guru::data_absen/$1');
		$routes->get('data-tugas/(:num)', 'Aplikasi\Guru::data_tugas/$1');
		$routes->get('data-tugas-siswa/(:num)/(:num)', 'Aplikasi\Guru::data_tugas_siswa/$1/$2');
		$routes->get('ubah-tugas/(:num)', 'Aplikasi\Guru::ubah_tugas/$1');
		$routes->get('buat-artikel', 'Aplikasi\Guru::buat_artikel');
		$routes->get('update-artikel/(:segment)', 'Aplikasi\Guru::update_artikel/$1');
		$routes->post('tambah-artikel', 'Aplikasi\Guru::tambah_artikel');
		$routes->put('ubah_artikel/(:num)', 'Aplikasi\Guru::ubah_artikel/$1');
		$routes->put('act_ubah_tugas/(:num)', 'Aplikasi\Guru::act_ubah_tugas/$1');
		$routes->put('tambah-komentar', 'Aplikasi\Guru::tambah_komentar');
	});

	// PROFIL
	$routes->group('profil', function ($routes) {
		$routes->get('/', 'Aplikasi\Profil::index');
		$routes->get('log-aktivitas', 'Aplikasi\Profil::log_aktivitas');
		$routes->get('ubah-password', 'Aplikasi\Profil::ubah_password');
		$routes->get('update_profil', 'Aplikasi\Profil::update_profil');
	});

	// DATA
	$routes->group('data', function ($routes) {
		$routes->get('ubah-data/(:num)', 'Aplikasi\Data::ubah_data/$1');
		$routes->get('ubah-siswa/(:num)', 'Aplikasi\Data::ubah_siswa/$1');
	});
});




/**
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
