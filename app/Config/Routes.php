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