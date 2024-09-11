<?php

declare(strict_types = 1);

namespace Core\Auth;

use Core\Database\Connector;
use Core\Session\Session;

class Auth
{
    private ?object $user = null;

    public function __construct(
        protected Connector $db,
        protected Session $session
    ) {}

    public function attempt(string $email, string $password): bool
    {
        $user = $this->getUserByEmail($email);

        if (!$user || !password_verify($password, $user->password)) {
            return false;
        }

        $this->session->put('user.id', $user->id);

        return true;
    }

    public function logout(): void
    {
        $this->session->forget('user.id');

        session_regenerate_id(true);
    }

    public function user(): object | false | null
    {
        return $this->user;
    }

    public function attachUser(): void
    {
        if (!$this->check()) {
            return;
        }

        $this->user = $this
            ->db
            ->query('SELECT * FROM users WHERE id = :id', ['id' => $this->session->get('user.id')])
            ->first();
    }

    protected function getUserByEmail(string $email): object | false
    {
        return $this
            ->db
            ->query('SELECT * FROM users WHERE email = :email', ['email' => $email])
            ->first();
    }

    public function check(): bool
    {
        return $this->session->has('user.id');
    }
}