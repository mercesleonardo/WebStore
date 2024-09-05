<?php

declare(strict_types = 1);

namespace Core\Bootstrap;

use Core\Containers\Container;
use Core\Database\Connector;
use Core\Database\DatabaseConfig;

class StartDatabase
{
    public function __construct(private Container $container)
    {}
    public function handle(): void
    {
        $config = $this->container->get('db.config');
        $connection = new Connector($config);

        $this->container->set('db', $connection);
    }
}