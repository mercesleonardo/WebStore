<?php

declare(strict_types = 1);

namespace Core\Bootstrap;

use Core\Application;
use Core\Container\Container;
use Core\Router\Router;

class StartRouter
{
    public function __construct(
        private Application $application
    ) {}

    public function handle(): void
    {
        $this->application->singleton(fn(Container $container) => $container->build(Router::class));
    }
}
