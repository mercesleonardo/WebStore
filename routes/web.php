<?php

declare(strict_types = 1);

use Core\Router\Router;

/** @var Router $router */
$router = container(Router::class);

//region Public Routes
$router->get('/', 'home');
$router->get('/product', 'product');
$router->get('/contact', 'contact/create');
$router->post('/contact', 'contact/store');
//endregion

//region Auth Routes
$router->get('/auth', '/auth/index');
$router->post('/auth/login', 'auth/login');
$router->get('/auth/logout', 'auth/logout')->middlewares('auth');
//endregion

//region Admin Routes
$router->get('/admin/messages', 'admin/messages')->middlewares('auth', 'admin');
//endregion

container()->set($router);