<?php

declare(strict_types = 1);

require __DIR__ . '/../vendor/autoload.php';

use Core\Application;
use Core\Containers\Container;

require_once base_path('routes/web.php');

(new Application(Container::getInstance()))->run();

