<?php

declare(strict_types=1);

namespace Core\Http;

use Core\Http\Response;

class RedirectResponse extends Response
{
    public function __construct(string $url, int $statusCode = 302, array $headers = [])
    {
        parent::__construct('', $statusCode, $headers);

        $this->header('Location', $url);
    }
}