<?php

declare(strict_types = 1);

namespace Core\Auth\Middlewares;

use Closure;
use Core\Auth\Auth;
use Core\Http\Request;

class StartAndAttachUser
{
    public function __construct(
        protected Auth $auth
    ) {}

    public function handle(Request $request, Closure $next)
    {
        $this->auth->attachUser();

        return $next($request);
    }
}
