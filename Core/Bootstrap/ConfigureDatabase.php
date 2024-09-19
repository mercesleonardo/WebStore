<?php

declare(strict_types = 1);

namespace Core\Bootstrap;

use Core\Application;
use Core\Database\DatabaseConfig;

class ConfigureDatabase
{
    public function __construct(
        private Application $application
    ) {}

    public function handle(): void
    {
        $this->application->singleton(fn() => new DatabaseConfig());
    }
}
