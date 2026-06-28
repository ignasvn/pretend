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