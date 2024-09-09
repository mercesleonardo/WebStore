<?php

declare(strict_types = 1);

require __DIR__ . '/../vendor/autoload.php';

use Core\Application;
use Core\Container\Container;

(new Application(
    Container::getInstance()
))->run();

