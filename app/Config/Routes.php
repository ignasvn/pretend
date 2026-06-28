<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
// $routes->get('/', 'Home::index');

// Halaman Login
$routes->get('/', 'AuthController::index');           // root redirect ke login
$routes->get('/login', 'AuthController::index');
$routes->post('/login', 'AuthController::login');
$routes->get('/logout', 'AuthController::logout');
    
// Dashboard (nanti kita isi)
$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']);

// Manajemen User — Admin only
$routes->get('/users', 'UserController::index', ['filter' => 'auth']);
$routes->get('/users/create', 'UserController::create', ['filter' => 'auth']);
$routes->post('/users/create', 'UserController::store', ['filter' => 'auth']);
$routes->get('/users/edit/(:num)', 'UserController::edit/$1', ['filter' => 'auth']);
$routes->post('/users/edit/(:num)', 'UserController::update/$1', ['filter' => 'auth']);
$routes->get('/users/delete/(:num)', 'UserController::delete/$1', ['filter' => 'auth']);

// Presensi
$routes->get('/presensi', 'PresensiController::index', ['filter' => 'auth']);
$routes->post('/presensi/store', 'PresensiController::store', ['filter' => 'auth']);
$routes->post('/presensi/koreksi/(:num)', 'PresensiController::koreksi/$1', ['filter' => 'auth']);

// Jadwal / Kelas
$routes->get('/jadwal', 'JadwalController::index', ['filter' => 'auth']);
$routes->get('/jadwal/create', 'JadwalController::create', ['filter' => 'auth']);
$routes->post('/jadwal/create', 'JadwalController::store', ['filter' => 'auth']);
$routes->get('/jadwal/edit/(:num)', 'JadwalController::edit/$1', ['filter' => 'auth']);
$routes->post('/jadwal/edit/(:num)', 'JadwalController::update/$1', ['filter' => 'auth']);
$routes->get('/jadwal/delete/(:num)', 'JadwalController::delete/$1', ['filter' => 'auth']);

// laporan
$routes->get('/laporan', 'LaporanController::index', ['filter' => 'auth']);
$routes->get('/laporan/export-csv', 'LaporanController::exportCsv', ['filter' => 'auth']);

// Profile
$routes->get('/profile', 'ProfileController::index', ['filter' => 'auth']);
$routes->get('/profile/edit', 'ProfileController::edit', ['filter' => 'auth']);
$routes->post('/profile/edit', 'ProfileController::update', ['filter' => 'auth']);