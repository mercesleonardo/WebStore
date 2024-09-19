<?php

declare(strict_types = 1);

namespace Core\Http;

class HeaderBag
{
    protected array $headers = [];

    public function __construct(array $server)
    {
        foreach ($server as $key => $value) {
            if (str_starts_with($key, 'HTTP_')) {
                $this->headers[
                    $this->fixHeaderName($key)
                ] = $value;
            }
        }
    }

    public function get(string $key)
    {
        return $this->headers[strtolower($key)] ?? null;
    }

    public function all(): array
    {
        return $this->headers;
    }

    public function fixHeaderName(string $name): string
    {
        return strtolower(str_replace(['HTTP_', '_'], ['', '-'], $name));
    }
}