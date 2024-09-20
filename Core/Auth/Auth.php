<?php

declare(strict_types = 1);

namespace Core\Auth;

use App\Models\User;
use Core\Database\Connector;
use Core\Session\Session;
use stdClass;

class Auth
{
    private ?User $user = null;

    public function __construct(
        protected Connector $db,
        protected Session $session
    ) {}

    public function attempt(string $email, string $password): bool
    {
        $user = $this->getUserByEmail($email);

        if (!$user || !password_verify($password, $user->password)) {
            throw new AuthException();
        }

        $this->session->put('user.id', $user->id);

        return true;
    }

    public function logout(): void
    {
        $this->session->forget('user.id');
        $this->user = null;

        session_regenerate_id(true);
    }

    public function user(): ?User
    {
        return $this->user;
    }

    public function attachUser(): void
    {
        if (!$this->check()) {
            return;
        }

        $this->user = User::find(
            $this->session->get('user.id')
        );
    }

    protected function getUserByEmail(string $email): User | stdClass | null
    {
        return User::query()->where('email', $email)->first();
    }

    public function check(): bool
    {
        return $this->session->has('user.id');
    }
}
