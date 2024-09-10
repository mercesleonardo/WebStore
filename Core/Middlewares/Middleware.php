<?php

namespace Core\Middlewares;

class Middleware
{
    protected static array $globalMiddlewares = [

    ];

    public static function getGlobalMiddlewares(): array
    {
        return static::$globalMiddlewares;
    }
}