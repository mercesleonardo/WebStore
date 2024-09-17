<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Auth;

use Core\Auth\Auth;
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
        return view('auth/index', [
            'title' => 'Admin Login',
            'heading' => 'Admin Login',
            'error' => $this->session->getFlash('error')
        ]);
    }

    #[Route('/auth/login', HttpMethod::Post)]
    public function login(Request $request): RedirectResponse
    {
        $validator = new Validator([
            'email'    => ['required', 'email', 'max:100'],
            'password' => ['required', 'string'],
        ], $request->input());

        if ($validator->fails()) {
            $this->session
                ->withInput($request->input())
                ->withErrors($validator->getErrors());

            return redirect('/auth');
        }

        if (!$this->auth->attempt($request->input('email'), $request->input('password'))) {
            $this->session
                ->withInput($request->input())
                ->flash('error', 'User not found or wrong password.');

            return redirect('/auth');
        }

        return redirect('/admin/messages');
    }

    #[Route('/auth/logout')]
    public function logout(): RedirectResponse
    {
        $this->auth->logout();

        return redirect('/');
    }
}