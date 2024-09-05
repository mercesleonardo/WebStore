<?php

declare(strict_types = 1);

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(base_path());
$dotenv->load();

$uri = $_SERVER['REQUEST_URI'];
$uri = parse_url($uri, PHP_URL_PATH);

$routes = [
    '/'        => 'home',
    '/product' => 'product',
    '/contact' => 'contact',
];

if (array_key_exists($uri, $routes)) {
    require base_path('src/Controllers/' . $routes[$uri] . '.php');
} else {
    abort();
}

