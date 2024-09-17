<?php

declare(strict_types = 1);

require __DIR__ . '/../vendor/autoload.php';

use Core\Application;
use Core\Http\Kernel;
use Core\Http\Request;

$app = Application::getInstance();
$kernel = $app->build(Kernel::class);

$kernel->handle(
    Request::createFromGlobals()
)->send();

