<?php

declare(strict_types = 1);

namespace Core\Auth;

use Exception;

class AuthException extends Exception
{
    protected $message = 'User not found or wrong password.';
}
