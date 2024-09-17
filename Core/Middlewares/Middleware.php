<?php

declare(strict_types = 1);

namespace Core\Middlewares;

use Core\Auth\Middlewares\Auth;
use Core\Auth\Middlewares\IsAdmin;
use Core\Auth\Middlewares\StartAndAttachUser;
use Exception;

class Middleware
{
    protected static array $globalMiddlewares = [
        StartAndAttachUser::class
    ];

    protected array $middlewares = [
        'auth'  => Auth::class,
        'admin' => IsAdmin::class,
    ];

    public static function getGlobalMiddlewares(): array
    {
        return static::$globalMiddlewares;
    }

    public function getMiddleware(string $middleware): string
    {
        if (!array_key_exists($middleware, $this->middlewares)) {
            throw new Exception('Middleware not found');
        }

        return $this->middlewares[$middleware];
    }
}