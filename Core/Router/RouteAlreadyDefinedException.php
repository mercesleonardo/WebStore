<?php

declare(strict_types = 1);

namespace Core\Router;

use Exception;

class RouteAlreadyDefinedException extends Exception
{
    public function __construct(Attributes\Route $route)
    {
        parent::__construct("Route {$route->path} already defined for method {$route->method->value}");
    }
}