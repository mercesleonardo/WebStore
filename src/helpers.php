<?php

declare(strict_types = 1);

use Core\Container\Container;
use Core\Http\Response;
use Core\Session\Session;

if (!function_exists('base_path')) {
    function base_path(string $path = ''): string
    {
        return dirname(__DIR__) . DIRECTORY_SEPARATOR . $path;
    }
}

if (!function_exists('resource_path')) {
    function resource_path(string $path = ''): string
    {
        return base_path('resources' . DIRECTORY_SEPARATOR . $path);
    }
}

if (!function_exists('dd')) {
    function dd(...$args): void
    {
        echo '<pre>';

        foreach ($args as $arg) {
            print_r($arg);
        }

        die();
    }
}

if (!function_exists('abort')) {
    function abort(int $code = 404): void
    {
        http_response_code($code);

        require resource_path('views/' . $code . '.php');

        die();
    }
}

if (!function_exists('route_is')) {
    function route_is(string $route): bool
    {
        $uri = $_SERVER['REQUEST_URI'];
        $uri = parse_url($uri, PHP_URL_PATH);

        return $uri === $route;
    }
}

if (!function_exists('format_money')) {
    function format_money(int $value): string
    {
        return 'R$' . number_format($value / 100, 2, ',', '.');
    }
}

if (!function_exists('env')) {
    function env(string $key, $default = null): mixed
    {
        return $_ENV[$key] ?? $default;
    }
}

if (!function_exists('container')) {
    /**
     * @template T of object|null
     * @param string|class-string<T>|null $service
     * @return (T is null ? Container : |class-string<T>)
     */
    function container(string $service = null): mixed
    {
        $container = Container::getInstance();

        if (is_string($service)) {
            return $container->get($service);
        }

        return $container;
    }
}

if (!function_exists('view')) {
    function view(string $view): string
    {
        return resource_path('views' . DIRECTORY_SEPARATOR . $view);
    }
}

if (!function_exists('old')) {
    function old(string $key, mixed $default = null): mixed
    {
        return \container(Session::class)->getOldInput($key, $default);
    }
}

if (!function_exists('validation_error')) {
    function validation_error(string $key): ?string
    {
        return \container(Session::class)->getError($key);
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url, int $code = Response::HTTP_FOUND): never
    {
        header("Location: $url", true, $code);
        exit();
    }
}