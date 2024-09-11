<?php

declare(strict_types = 1);

namespace Core\Middlewares;

use App\Enums\Role;
use Core\Auth\Auth;

class IsAdmin
{
    public function __construct(
        protected Auth $auth,
    ) {}

    public function handle(): void
    {
        $user = $this->auth->user();

        if (!$user || $user->role !== Role::Admin->value) {
            redirect('/');
        }
    }
}