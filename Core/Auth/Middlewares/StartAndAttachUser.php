<?php

declare(strict_types=1);

namespace Core\Auth\Middlewares;

use Core\Auth\Auth;

class StartAndAttachUser
{
    public function __construct(protected Auth $auth){}

    public function handle(): void
    {
        $this->auth->attachUser();
    }
}