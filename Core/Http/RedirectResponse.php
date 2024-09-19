<?php

declare(strict_types=1);

namespace Core\Http;

use Core\Session\Session;

class RedirectResponse extends Response
{
    protected ?Request $request = null;
    protected ?Session $session = null;

    public function __construct(string $url = null, int $statusCode = 302, array $headers = [])
    {
        parent::__construct('', $statusCode, $headers);

        if ($url) {
            $this->to($url);
        }
    }

    public function setSession(Session $session): static
    {
        $this->session = $session;

        return $this;
    }

    public function setRequest(Request $request): static
    {
        $this->request = $request;

        return $this;
    }

    public function withErrors(array $errors): static
    {
        $this->session->withErrors($errors);

        return $this;
    }

    public function withInput(): static
    {
        $this->session->withInput($this->request?->input());

        return $this;
    }

    public function with(string $key, mixed $value): static
    {
        $this->session->flash($key, $value);

        return $this;
    }

    public function back(string $fallback = '/'): static
    {
        $this->to(
            $this->request?->headers()->get('referer')
            ?? $this->session?->getPreviousUrl()
            ?? $fallback
        );

        return $this;
    }

    private function to(string $url, int $status = 302, array $headers = []): static
    {
        $this->setHeaders($headers);
        $this->header('Location', $url);
        $this->setStatusCode($status);

        return $this;
    }
}