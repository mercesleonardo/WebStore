<?php

namespace Core\Middlewares;

class Middleware
{
    protected static array $globalMiddlewares = [
        StartSession::class,
    ];

    public static function getGlobalMiddlewares(): array
    {
        return static::$globalMiddlewares;
    }
}