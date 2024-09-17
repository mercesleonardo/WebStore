<?php

declare(strict_types = 1);

namespace Core\Http;

class Request
{
    public function __construct(
        protected string $path = '/',
        protected string $method = 'GET',
        protected array $query = [],
        protected array $input = [],
    ) {}

    public static function createFromGlobals(): static
    {
        return new static(
            path: parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
            method: $_SERVER['REQUEST_METHOD'],
            query: $_GET ?? [],
            input: $_POST ?? [],
        );
    }

    public function path(): string
    {
        return $this->path;
    }

    public function method(): string
    {
        return $this->method;
    }

    public function input(string $key = null)
    {
        if (! $key) {
            return $this->input;
        }

        return $this->input[$key] ??
            $this->query[$key] ??
            null;
    }

    public function get(string $key = null)
    {
        if (! $key) {
            return $this->input;
        }

        return $this->query[$key] ?? null;
    }

    public function all(): array
    {
        return array_merge($this->query, $this->input);
    }
}