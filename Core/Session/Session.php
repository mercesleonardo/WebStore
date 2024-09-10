<?php

declare(strict_types=1);

namespace Core\Session;

class Session
{
    public function __construct()
    {
        session_start();

        $this->agedSession();
    }

    public function put(string $key, mixed $value): self
    {
        $keys = explode('.', $key);
        $session =& $_SESSION;

        while (count($keys) > 1) {
            $key = array_shift($keys);

            if (!isset($session[$key]) ||!is_array($session[$key])) {
                $session[$key] = [];
            }

            $session =& $session[$key];
        }

        $session[array_shift($keys)] = $value;

        return $this;

    }

    public function get(string $key, mixed $default = null): mixed
    {
        $keys = explode('.', $key);
        $session = $_SESSION;

        foreach ($keys as $key) {
            if (!isset($session[$key])) {
                return $default;
            }

            $session = $session[$key];
        }

        return $session;
    }

    public function flash(string $key, mixed $value): self
    {
        $this->put('_flash.new.' . $key, $value);

        return $this;
    }

    public function withErrors(array $input): self
    {
        $this->flash('input', $input);

        return $this;
    }

    public function withInput(array $input): self
    {
        $this->flash('input', $input);

        return $this;
    }

    public function getError(string $key): ?string
    {
        return $this->get('_flash.old.errors.' . $key . '.0');
    }

    public function getOldInput(string $key, mixed $default = null): mixed
    {
        return $this->get('_flash.old.input.' . $key, $default);
    }

    private function agedSession(): void
    {
        $this->put('_flash.old', $this->get('_flash.new', []));
        $this->put('_flash.new', []);
    }
}