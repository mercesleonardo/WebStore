<?php

declare(strict_types = 1);

namespace Core\Facades;

use Core\Facade;

/**
 * @method static \Core\Session\Session put(string $key, mixed $value)
 * @method static mixed get(string $key, mixed $default = null)
 * @method static \Core\Session\Session flash(string $key, mixed $value)
 * @method static \Core\Session\Session withErrors(array $errors)
 * @method static \Core\Session\Session withInput(array $input)
 * @method static string|null getError(string $key)
 * @method static mixed getOldInput(string $key, mixed $default = null)
 * @method static mixed getFlash(string $key, mixed $default = null)
 * @method static \Core\Session\Session forget(string $key)
 * @method static bool has(string $key)
 */
class Session extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Core\Session\Session::class;
    }
}
