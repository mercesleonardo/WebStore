<?php

declare(strict_types = 1);

namespace Core\Router;

use Core\Http\Request;
use RuntimeException;

class ParameterBag
{
    private array $parameters = [];

    public function __construct(protected Request $request, protected Route $route)
    {
        $this->hydrateParameters();
    }

    private function hydrateParameters(): void
    {
        $uri = $this->route->uri;
        $uri = preg_replace('/\{([a-zA-Z0-9]+)\}/', '([a-zA-Z0-9\-_]+)+', $uri);
        $uri = str_replace('/', '\/', $uri);

        preg_match('/^' . $uri . '$/', $this->request->path(), $matches);
        array_shift($matches);

        $parameters     = [];
        $parameterNames = $this->getParametersNames();

        foreach ($matches as $index => $match) {
            $parameters[$parameterNames[$index]] = $match;
        }

        $this->parameters = $parameters;
    }

    private function getParametersNames()
    {
        preg_replace('/\{([a-zA-Z0-9]+)\}/', $this->route->uri, $uri);
        array_shift($uri);

        return $uri[0];
    }

    public function get(string $key): int | string
    {
        if (!array_key_exists($key, $this->parameters)) {
            throw new RuntimeException("O parâmetro $key não foi definido para essa rota");
        }

        $value = $this->parameters[$key];

        if (is_numeric($value)) {
            return (int) $value;
        }

        return $value;
    }
}
