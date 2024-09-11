<?php

declare(strict_types = 1);

namespace Core\Middlewares;

use Core\Auth\Auth as Authentication;

class Auth
{
    public function __construct(
        protected Authentication $auth,
    ) {}

    public function handle(): void
    {
        if ($this->auth->user() === null) {
            redirect('/auth');
        }
    }
}