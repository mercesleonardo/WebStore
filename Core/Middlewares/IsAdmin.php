<?php

declare(strict_types = 1);

namespace Core\Middlewares;

use App\Enums\Role;
use Core\Session\Session;

class IsAdmin
{
    public function __construct(
        private Session $session
    ) {}

    public function handle(): void
    {
        $user = $this->session->get('user');

        if (!$user || $user->role !== Role::Admin->value) {
            header('Location: /');
            exit;
        }
    }
}