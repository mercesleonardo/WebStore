<?php

declare(strict_types = 1);

namespace Core\Session;

use Core\Http\Request;
use Illuminate\Support\Arr;

class Session
{
    public function __construct()
    {
        session_start();

        $this->agedSession();
    }

    public function put(string $key, mixed $value): self
    {
        $session = &$_SESSION;

        Arr::set($session, $key, $value);

        return $this;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return Arr::get($_SESSION, $key, $default);
    }

    public function flash(string $key, mixed $value): self
    {
        $this->put('_flash.new.' . $key, $value);

        return $this;
    }

    public function withErrors(array $errors): self
    {
        $this->flash('errors', $errors);

        return $this;
    }

    public function withInput(array $input): self
    {
        $input = (new PrepareDataForFlash(
            $input
        ))->handle();

        $this->flash('input', $input);

        return $this;
    }

    public function getError(string $key): ?string
    {
        return $this->getFlash("errors.$key.0");
    }

    public function getOldInput(string $key, mixed $default = null): mixed
    {
        return $this->getFlash("input.$key", $default);
    }

    public function getFlash(string $key, mixed $default = null): mixed
    {
        return $this->get("_flash.old.$key", $default);
    }

    private function agedSession(): void
    {
        $this->put('_flash.old', $this->get('_flash.new', []));
        $this->put('_flash.new', []);
    }

    public function forget(string $key): static
    {
        $session = &$_SESSION;

        Arr::forget($session, $key);

        return $this;
    }

    public function has(string $string): bool
    {
        return $this->get($string) !== null;
    }

    public function setPreviousUrl(Request $request): void
    {
        if ($request->method() == 'GET') {
            $this->put('_previous.url', $request->fullUrl());
        }
    }

    public function getPreviousUrl(): ?string
    {
        return $this->get('_previous.url');
    }
}
