<?php

declare(strict_types = 1);

use Core\Http\RedirectResponse;
use Core\Http\Response;

if (!function_exists('response')) {
    function response(mixed $content = '', int $statusCode = 200, array $headers = []): Response
    {
        return new Response($content, $statusCode, $headers);
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url = null, int $statusCode = 302, array $headers = []): RedirectResponse
    {
        $redirector = container('redirector');

        if ( is_null($url)) {
            return $redirector;
        }

        return $redirector->to($url, $statusCode, $headers);
    }
}
