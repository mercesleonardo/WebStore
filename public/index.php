<?php

declare(strict_types = 1);

require __DIR__ . '/../vendor/autoload.php';

use Core\Application;
use Core\Container\Container;
use Core\Http\Request;

$response = (new Application(
    Request::createFromGlobals(),
    Container::getInstance()
))->run();

$response->send();

