<?php

declare(strict_types = 1);

namespace Core\Router;

use Core\Http\Enums\HttpMethod;

readonly class Route
{
    public function __construct(
        public string $uri,
        public string $controller,
        public HttpMethod $method,
        public string $action,
        public array $middlewares = []
    ) {}

    public function match(string $uri, string $method): bool
    {
        return $this->uri === $uri && $this->method->value === $method;
    }

    public function run(): mixed
    {
        return container()
            ->call($this->controller, $this->action);
    }
}