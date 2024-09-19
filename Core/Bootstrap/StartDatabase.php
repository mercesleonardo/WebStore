<?php

declare(strict_types = 1);

namespace Core\Bootstrap;

use Core\Application;
use Core\Container\Container;
use Core\Database\Connector;

class StartDatabase
{
    public function __construct(
        private Application $application
    ) {}

    public function handle(): void
    {
        $this->application->singleton(function (Container $container) {
            return $container->build(Connector::class);
        });
    }
}