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

//region Admin Routes
$router->get('/admin/login', 'admin/login/index');
$router->post('/admin/login', 'admin/login/login');

$router->get('/admin/messages', 'admin/messages');
//endregion

container()->set($router);