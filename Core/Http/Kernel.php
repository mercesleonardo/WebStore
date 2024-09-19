<?php

declare(strict_types=1);

namespace Core\Http;

use Core\Application;
use Core\Auth\Middlewares\Auth;
use Core\Auth\Middlewares\IsAdmin;
use Core\Auth\Middlewares\StartAndAttachUser;
use Core\Pipeline\Pipeline;
use Core\Router\Router;
use Exception;

class Kernel
{
    protected array $globalMiddlewares = [
        StartAndAttachUser::class
    ];

    protected array $middlewares = [
        'auth'  => Auth::class,
        'admin' => IsAdmin::class,
    ];

    public function __construct(protected Application $app, protected Router $router)
    {}

    public function handle(Request $request): Response
    {
        $this->app->registerRequest($request);

        $route = $this->router->findRoute($request);
        $middlewares = $this->prepareMiddlewares($route->middlewares);

        $response = (new Pipeline($this->app))
            ->send($request)
            ->through($middlewares)
            ->then(fn () => $route->run());

        if ($response instanceof Response) {
            return $response;
        }

        if (is_array($response)) {
            return new JsonResponse($response);
        }

        return new Response($response ?? '');
    }

    private function prepareMiddlewares(array $middlewares): array
    {
        $middlewares = array_map(function ($middleware, string $alias) {
            if (array_key_exists($alias, $this->middlewares)) {
                return $this->middlewares[$alias];
            }

            if (class_exists($middleware)) {
                return $middleware;
            }

            throw new Exception("Middleware {$middleware} not found");

        }, $middlewares, array_values($middlewares));

        return array_merge($this->globalMiddlewares, $middlewares);
    }
}