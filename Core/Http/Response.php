<?php

declare(strict_types = 1);

namespace Core\Http;

use InvalidArgumentException;

class Response
{
    public const HTTP_OK           = 200;
    public const HTTP_CREATED      = 201;
    public const HTTP_MOVED        = 301;
    public const HTTP_FOUND        = 302;
    public const HTTP_BAD_REQUEST  = 400;
    public const HTTP_UNAUTHORIZED = 401;
    public const HTTP_FORBIDDEN    = 403;
    public const HTTP_NOT_FOUND    = 404;
    public const HTTP_SERVER_ERROR = 500;

    protected array $statusTexts = [
        200 => 'OK',
        201 => 'Created',
        301 => 'Moved Permanently',
        302 => 'Found',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        403 => 'Forbidden',
        404 => 'Not Found',
        500 => 'Internal Server Error',
    ];

    private array $headers;

    private string $content;

    private int $statusCode;

    private string $statusText;

    private string $protocolVersion = '1.0';

    public function __construct(mixed $content = '', int $statusCode = 200, array $headers = [])
    {
        $this->setContent($content);
        $this->setStatusCode($statusCode);
        $this->setHeaders($headers);
    }

    public function setContent(mixed $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function header(string $header, string $value, bool $replace = true): static
    {
        if ($replace) {
            unset($this->headers[$header]);
        }

        if (!array_key_exists($header, $this->headers)) {
            $this->headers[$header] = $value;
        }

        return $this;
    }

    public function setStatusCode(int $statusCode, string $statusText = null): static
    {
        if ($statusCode < 100 || $statusCode >= 600) {
            throw new InvalidArgumentException('Invalid HTTP status code');
        }

        $this->statusCode = $statusCode;
        $this->statusText = $statusText ?: $this->statusTexts[$statusCode];

        return $this;
    }

    public function send(): void
    {
        $this->sendHeaders();
        $this->sendContent();
    }

    private function sendHeaders(): void
    {
        if (headers_sent()) {
            return;
        }

        foreach ($this->headers as $header => $value) {
            header(sprintf('%s: %s', $header, $value), false, $this->statusCode);
        }

        header(sprintf('HTTP/%s %s %s', $this->protocolVersion, $this->statusCode, $this->statusText), true, $this->statusCode);
    }

    private function sendContent(): void
    {
        echo $this->content;
    }

    public function json(mixed $data = [], int $statusCode = 200, array $headers = []): JsonResponse
    {
        return new JsonResponse($data, $statusCode, $headers);
    }

    public function redirect(string $url, int $statusCode = 302, array $headers = []): RedirectResponse
    {
        return new RedirectResponse($url, $statusCode, $headers);
    }

    public function setHeaders(array $headers): static
    {
        $this->headers = $headers;

        return $this;
    }
}
