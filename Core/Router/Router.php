<?php

declare(strict_types = 1);

namespace Core\Router;

use Core\Http\Request;
use Core\Router\Loader\RouteLoader;
use ReflectionClass;

class Router
{
    private array $routes = [];

    public function __construct(
        private RouteLoader $routeLoader
    ) {
        $this->addLoadedRoutes();
    }

    public function findRoute(Request $request): Route
    {
        $route = array_values(
            array_filter($this->routes, fn (Route $route) => $route->match(
                $request->path(),
                $request->method()
            ))
        );

        if (count($route) === 0) {
            abort();
        }

        return $route[0];
    }

    private function addLoadedRoutes(): void
    {
        $routes = $this->routeLoader->getRoutes();

        foreach ($routes as $route) {
            $reflection = new ReflectionClass($route);

            foreach ($reflection->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {
                $attributes = $method->getAttributes(Attributes\Route::class);

                if (count($attributes) === 0) {
                    continue;
                }

                /** @var Attributes\Route $attribute */
                $attribute = $attributes[0]->newInstance();

                if ($this->routeIsAlreadyRegistered($attribute)) {
                    throw new RouteAlreadyDefinedException($attribute);
                }

                $this->routes[] = new Route(
                    uri: $attribute->path,
                    controller: $route,
                    method: $attribute->method,
                    action: $method->getName(),
                    middlewares: $attribute->middlewares
                );
            }
        }
    }

    private function routeIsAlreadyRegistered(Attributes\Route $attribute): bool
    {
        $count = array_filter(
            $this->routes,
            fn (Route $route) => $route->uri === $attribute->path
                && $route->method === $attribute->method
        );

        return count($count) > 0;
    }
}