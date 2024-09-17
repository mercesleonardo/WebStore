<?php

declare(strict_types = 1);

namespace Core;

use Closure;
use Core\Container\Container;
use Core\Http\JsonResponse;
use Core\Http\Request;
use Core\Http\Response;
use Core\Middlewares\Middleware;
use Core\Router\Router;

class Application
{
    private array $bootstrappers = [
        \Core\Bootstrap\LoadEnvFile::class,
        \Core\Bootstrap\ConfigureDatabase::class,
        \Core\Bootstrap\StartDatabase::class,
        \Core\Bootstrap\StartRouter::class,
        \Core\Bootstrap\LoadRoutes::class,
        \Core\Bootstrap\StartSession::class,
        \Core\Bootstrap\ConfigureAuth::class,
    ];

    public function __construct(
        private Request $request,
        private Container $container
    )
    {
        $this->container->set($this->request);
    }

    public function run(): Response
    {
        $this->bootstrap();

        return $this->dispatchToRouter();
    }

    private function bootstrap(): void
    {
        foreach ($this->bootstrappers as $bootstrapper) {
            (new $bootstrapper(
                $this
            ))->handle();
        }
    }

    private function dispatchToRouter(): Response
    {
        $this->runGlobalMiddlewares();

        /** @var Router $router */
        $router   = $this->container->get(Router::class);
        $response = $router->findRoute();

        if ($response instanceof Response) {
            return $response;
        }

        if (is_array($response)) {
            return new JsonResponse($response);
        }

        return new Response($response);
    }

    private function runGlobalMiddlewares(): void
    {
        $middlewares = Middleware::getGlobalMiddlewares();

        foreach ($middlewares as $middleware) {
            $this->container->build($middleware)->handle();
        }
    }

    public function singleton(Closure $closure): void
    {
        $this->container->set($closure($this->container));
    }
}