<?php

declare(strict_types = 1);

namespace Core\Auth\Middlewares;

use Closure;
use Core\Auth\Auth as Authentication;
use Core\Http\Request;

class Auth
{
    public function __construct(
        protected Authentication $auth,
    ) {}

    public function handle(Request $request, Closure $next)
    {
        if ($this->auth->user() === null) {
            return redirect('/auth');
        }

        return $next($request);
    }
}