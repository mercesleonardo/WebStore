<?php

declare(strict_types = 1);

namespace Core\Facades;

use App\Models\User;
use Core\Facade;

/**
 * @method static bool attempt(string $email, string $password)
 * @method static void logout()
 * @method static User|null user()
 * @method static bool check()
 */
class Auth extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Core\Auth\Auth::class;
    }
}