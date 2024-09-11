<?php

declare(strict_types = 1);

namespace Core\Middlewares;

use Core\Session\Session;

class Auth
{
    public function __construct(
        private Session $session
    ) {}

    public function handle(): void
    {
        if ($this->session->get('user') === null) {
            header('Location: /auth');
            exit;
        }
    }
}