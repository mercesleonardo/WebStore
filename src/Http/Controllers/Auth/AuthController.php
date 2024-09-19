<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Auth;

use Core\Auth\Auth;
use Core\Html\View;
use Core\Http\Enums\HttpMethod;
use Core\Http\RedirectResponse;
use Core\Http\Request;
use Core\Router\Attributes\Route;
use Core\Session\Session;
use Core\Validation\Validator;

class AuthController
{
    public function __construct(
        private Session $session,
        private Auth $auth
    ) {}

    #[Route('/auth')]
    public function index(): string
    {
        return (new View('login'))->render('auth/index', [
            'title' => 'Admin Login',
            'error' => $this->session->getFlash('error'),
        ]);
    }

    #[Route('/auth/login', HttpMethod::Post)]
    public function login(Request $request): RedirectResponse
    {
        (new Validator([
            'email'    => ['required', 'email', 'max:100'],
            'password' => ['required', 'string'],
        ], $request->input()))->validate();

        $this->auth->attempt(
            $request->input('email'),
            $request->input('password')
        );

        return redirect('/admin/messages');
    }

    #[Route('/auth/logout')]
    public function logout(): RedirectResponse
    {
        $this->auth->logout();

        return redirect('/');
    }
}
