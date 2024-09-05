<?php

declare(strict_types = 1);

namespace Core;

use Core\Containers\Container;

class Application
{
    private array $bootstrappers = [
        \Core\Bootstrap\LoadEnvFile::class,
        \Core\Bootstrap\ConfigureDatabase::class,
        \Core\Bootstrap\StartDatabase::class,
    ];

    public function __construct(private Container $container) {

    }

    public function run(): void
    {
        $this->bootstrap();
    }

    private function bootstrap(): void
    {
        foreach ($this->bootstrappers as $bootstrapper) {
            (new $bootstrapper($this->container))->handle();

        }
    }
}