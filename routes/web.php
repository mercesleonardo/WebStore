<?php

declare(strict_types = 1);

use Core\Router\Router;

/** @var Router $router */
$router = container(Router::class);

//region Public Routes
$router->get('/', 'home');
$router->get('/product', 'product');
$router->get('/contact', 'contact');
//endregion

//region Admin Routes
$router->get('/admin/messages', 'admin/messages');
//endregion

container()->set($router);