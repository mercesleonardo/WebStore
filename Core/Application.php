<?php

declare(strict_types = 1);

namespace Core;

use Core\Containers\Container;
use Core\Router\Router;

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
        $this->dispatchToRouter();
    }

    private function bootstrap(): void
    {
        foreach ($this->bootstrappers as $bootstrapper) {
            (new $bootstrapper($this->container))->handle();

        }
    }

    private function dispatchToRouter(): void
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = parse_url($uri, PHP_URL_PATH);

        /** @var Router $router */
        $router = container(Router::class);
        $router->findRoute($uri, $_SERVER['REQUEST_METHOD']);

    }
}