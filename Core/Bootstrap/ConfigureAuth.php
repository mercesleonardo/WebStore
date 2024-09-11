<?php

declare(strict_types = 1);

namespace Core\Bootstrap;

use Core\Application;
use Core\Auth\Auth;
use Core\Container\Container;

class ConfigureAuth
{
    public function __construct(
        private Application $app
    ) {}

    public function handle(): void
    {
        $this->app->singleton(
            fn (Container $container) => $container->build(Auth::class)
        );
    }
}