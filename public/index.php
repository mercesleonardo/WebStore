<?php

declare(strict_types = 1);

require __DIR__ . '/../vendor/autoload.php';

use Core\Application;
use Core\Containers\Container;
use Core\Database\Connector;

(new Application(Container::getInstance()))->run();

$uri = $_SERVER['REQUEST_URI'];
$uri = parse_url($uri, PHP_URL_PATH);

$routes = require base_path('routes/web.php');

if (array_key_exists($uri, $routes)) {
    require base_path('src/Controllers/' . $routes[$uri] . '.php');
} else {
    abort();
}

