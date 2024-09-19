<?php

declare(strict_types = 1);

namespace Core\Http;

class Request
{
    protected HeaderBag $headers;

    public function __construct(
        protected string $path = '/',
        protected string $method = 'GET',
        protected array $query = [],
        protected array $input = [],
        protected array $server = []
    ) {
        $this->headers = new HeaderBag($this->server);
    }

    public static function createFromGlobals(): static
    {
        return new static(
            path: parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH),
            method: $_SERVER['REQUEST_METHOD'],
            query: $_GET,
            input: $_POST,
            server: $_SERVER
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
        if (!$key) {
            return $this->input;
        }

        return $this->input[$key] ??
            $this->query[$key] ??
            null;
    }

    public function get(string $key = null)
    {
        if (!$key) {
            return $this->query;
        }

        return $this->query[$key] ?? null;
    }

    public function all(): array
    {
        return array_merge($this->query, $this->input);
    }

    public function headers(): HeaderBag
    {
        return $this->headers;
    }

    public function host(): string
    {
        return $this->headers->get('Host')
            ?? $this->server['SERVER_NAME'];
    }

    public function isSecure(): bool
    {
        return isset($this->server['HTTPS'])
            && $this->server['HTTPS'] === 'on';
    }

    public function port()
    {
        return $this->server['SERVER_PORT'];
    }

    public function httpScheme(): string
    {
        return $this->isSecure() ? 'https' : 'http';
    }

    public function getSchemeAndHttpHost(): string
    {
        return vsprintf('%s://%s', [
            $this->httpScheme(),
            $this->host(),
        ]);
    }

    public function fullUrl(): string
    {
        $url = vsprintf('%s%s', [
            $this->getSchemeAndHttpHost(),
            $this->path(),
        ]);

        if (!empty($this->query)) {
            $url .= '?' . http_build_query($this->query);
        }

        return $url;
    }
}
