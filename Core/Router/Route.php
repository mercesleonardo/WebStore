<?php

declare(strict_types = 1);

namespace Core\Router;

use Core\Http\Enums\HttpMethod;

readonly class Route
{
    private string $regex;

    public function __construct(
        public string $uri,
        public string $controller,
        public HttpMethod $method,
        public string $action,
        public array $middlewares = []
    ) {
        $this->genarateRegex();
    }

    public function match(string $uri, string $method): bool
    {
        return preg_match($this->regex, $uri) === 1 && $this->method->value === $method;
    }

    public function run(): mixed
    {
        return container()
            ->call($this->controller, $this->action);
    }

    private function genarateRegex(): void
    {
        $uri = preg_replace('/\{([a-zA-Z0-9]+)\}/', '?(/[a-zA-Z0-9\-_]+)+', $this->uri);
        $uri = str_replace('/', '\/', $uri);

        $this->regex = '/^' . $uri . '$/';
    }
}
