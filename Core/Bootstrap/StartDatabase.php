<?php

declare(strict_types = 1);

namespace Core\Bootstrap;

use Core\Containers\Container;
use Core\Database\Connector;

class StartDatabase
{
    public function __construct(private Container $container)
    {}
    public function handle(): void
    {
        $connection = $this->container->build(Connector::class);

        $this->container->set($connection);
    }
}