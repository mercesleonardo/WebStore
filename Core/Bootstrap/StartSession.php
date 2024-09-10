<?php

declare(strict_types=1);

namespace Core\Bootstrap;

use Core\Application;
use Core\Session\Session;

class StartSession
{
    public function __construct(private Application $application)
    {

    }

    public function handle(): void
    {
        $this->application->singleton(fn () => new Session());
    }
}