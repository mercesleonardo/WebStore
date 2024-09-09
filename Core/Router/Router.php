<?php

declare(strict_types = 1);

namespace Core\Router;

class Router
{
    private array $routes = [];

    public function get(string $uri, string $controller): void
    {
        $this->addMethod($uri, $controller, 'GET');
    }

    public function post(string $uri, string $controller): void
    {
        $this->addMethod($uri, $controller, 'POST');
    }

    public function put(string $uri, string $controller): void
    {
        $this->addMethod($uri, $controller, 'PUT');
    }

    public function patch(string $uri, string $controller): void
    {
        $this->addMethod($uri, $controller, 'PATCH');
    }

    public function delete(string $uri, string $controller): void
    {
        $this->addMethod($uri, $controller, 'DELETE');
    }

    private function addMethod(string $uri, string $controller, string $method): void
    {
        $this->routes[] = [
            'uri'     => $uri,
            'controller' => $controller,
            'method' => $method
        ];
    }

    public function findRoute(string $uri, string $method): void
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
                require base_path('src/Controllers/' . $route['controller'] . '.php');

                return;
            }

        }

        abort();
    }

}