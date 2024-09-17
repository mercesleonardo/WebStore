<?php

declare(strict_types = 1);

namespace Core\Router\Attributes;

use Attribute;
use Core\Http\Enums\HttpMethod;

#[Attribute(Attribute::TARGET_METHOD)]
class Route
{
    public function __construct(
        public string $path,
        public HttpMethod $method = HttpMethod::Get,
        public array $middlewares = []
    ) {}
}