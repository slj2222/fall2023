<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

 $routes->get('/', 'SignupController::index');
 $routes->get('/signup', 'SignupController::index');
 $routes->match(['get', 'post'], 'SignupController/store', 'SignupController::store');
 $routes->match(['get', 'post'], 'LoginController/loginAuth', 'LoginController::loginAuth');
 $routes->get('/login', 'LoginController::index');
 $routes->get('/profile', 'ProfileController::index',['filter' => 'authGuard']);




