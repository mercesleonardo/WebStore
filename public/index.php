<?php

declare(strict_types = 1);

require __DIR__ . '/../vendor/autoload.php';

$uri = $_SERVER['REQUEST_URI'];
$uri = parse_url($uri, PHP_URL_PATH);

$routes = [
    '/'        => 'home',
    '/contact' => 'contact',
];

if (array_key_exists($uri, $routes)) {
    require base_path('src/Controllers/' . $routes[$uri] . '.php');
} else {
    abort();
}

