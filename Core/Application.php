<?php

declare(strict_types = 1);

namespace Core;

use Closure;
use Core\Container\Container;
use Core\Router\Router;

class Application
{
    private array $bootstrappers = [
        \Core\Bootstrap\LoadEnvFile::class,
        \Core\Bootstrap\ConfigureDatabase::class,
        \Core\Bootstrap\StartDatabase::class,
        \Core\Bootstrap\StartRouter::class,
        \Core\Bootstrap\LoadRoutes::class,
    ];

    public function __construct(
        private Container $container
    ) {}

    public function run(): void
    {
        $this->bootstrap();
        $this->dispatchToRouter();
    }

    private function bootstrap(): void
    {
        foreach ($this->bootstrappers as $bootstrapper) {
            (new $bootstrapper(
                $this
            ))->handle();
        }
    }

    private function dispatchToRouter(): void
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = parse_url($uri, PHP_URL_PATH);

        /** @var Router $router */
        $router = $this->container->get(Router::class);
        $router->findRoute($uri, $_SERVER['REQUEST_METHOD']);
    }

    public function singleton(Closure $closure): void
    {
        $this->container->set($closure($this->container));
    }
}