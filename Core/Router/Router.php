<?php

declare(strict_types = 1);

namespace Core\Router;

use Core\Middlewares\Middleware;

class Router
{
    private array $routes = [];

    public function __construct(
        private Middleware $middleware
    ) {}

    public function get(string $uri, string $controller): Router
    {
        return $this->addMethod($uri, $controller, 'GET');
    }

    public function post(string $uri, string $controller): Router
    {
        return $this->addMethod($uri, $controller, 'POST');
    }

    public function put(string $uri, string $controller): Router
    {
        return $this->addMethod($uri, $controller, 'PUT');
    }

    public function patch(string $uri, string $controller): Router
    {
        return $this->addMethod($uri, $controller, 'PATCH');
    }

    public function delete(string $uri, string $controller): Router
    {
        return $this->addMethod($uri, $controller, 'DELETE');
    }

    public function middlewares(...$middlewares): void
    {
        $this->routes[array_key_last($this->routes)]['middlewares'] = $middlewares;
    }

    private function addMethod(string $uri, string $controller, string $method): Router
    {
        $this->routes[] = [
            'uri'        => $uri,
            'controller' => $controller,
            'method'     => $method,
        ];

        return $this;
    }

    public function findRoute(string $uri, string $method): void
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
                $this->checkAndRunMiddlewares($route);

                require base_path('src/Controllers/' . $route['controller'] . '.php');

                return;
            }
        }

        abort();
    }

    private function checkAndRunMiddlewares(array $route): void
    {
        if (isset($route['middlewares'])) {
            foreach ($route['middlewares'] as $middleware) {
                container()
                    ->build($this->middleware->getMiddleware($middleware))
                    ->handle();
            }
        }
    }
}