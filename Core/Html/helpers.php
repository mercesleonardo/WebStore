<?php

declare(strict_types = 1);

use Core\Html\View;

if (!function_exists('view')) {
    function view(string $view, array $data = []): string
    {
        return (new View())->render($view, $data);
    }
}
