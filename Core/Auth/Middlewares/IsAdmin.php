<?php

declare(strict_types = 1);

namespace Core\Auth\Middlewares;

use App\Enums\Role;
use Closure;
use Core\Auth\Auth;
use Core\Http\Request;

class IsAdmin
{
    public function __construct(
        protected Auth $auth,
    ) {}

    public function handle(Request $request, Closure $next)
    {
        $user = $this->auth->user();

        if (!$user || $user->role !== Role::Admin->value) {
            return redirect('/');
        }

        return $next($request);
    }
}
