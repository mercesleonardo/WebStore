<?php

declare(strict_types = 1);

namespace Core\Bootstrap;

use Core\Containers\Container;
use Core\Database\DatabaseConfig;

class ConfigureDatabase
{
    public function __construct(private Container $container)
    {}
    public function handle(): void
    {
        $this->container->set(new DatabaseConfig());
    }
}