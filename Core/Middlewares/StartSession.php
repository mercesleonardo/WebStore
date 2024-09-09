<?php

declare(strict_types = 1);

namespace Core\Middlewares;

class StartSession
{
    public function handle(): void
    {
        session_start();
    }
}