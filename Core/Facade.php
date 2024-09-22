<?php

declare(strict_types=1);

namespace Core;

use RuntimeException;

abstract class Facade
{
    protected static function getFacadeAccessor()
    {
        throw new RuntimeException('Facade does not implement getFacadeAccessor method');
    }

    protected static function resolveFacadeInstance(): mixed
    {
        $facadeAccessor = static::getFacadeAccessor();

        return container($facadeAccessor);
    }

    public static function __callStatic($method, $args)
    {
        $instance = static::resolveFacadeInstance();

        if (!$instance) {
            throw new RuntimeException('Unable to resolve the instance of the facade');
        }

        return $instance->$method(...$args);
    }
}