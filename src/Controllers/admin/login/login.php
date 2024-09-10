<?php

declare(strict_types = 1);

use Core\Session\Session;
use Core\Validation\Validator;

$validator = new Validator([
    'email'    => ['required', 'email', 'max:100'],
    'password' => ['required', 'string'],
], $_POST);

$session = container(Session::class);

if ($validator->fails()) {
    unset($_POST['password']);

    $session
        ->withInput($_POST)
        ->withErrors($validator->getErrors());

    header('Location: /admin/login');
    exit();
}

$user = container(Core\Database\Connector::class)
    ->query('SELECT * FROM users WHERE email = :email', ['email' => $_POST['email']])
    ->first();

if (!$user || !password_verify($_POST['password'], $user->password)) {
    unset($_POST['password']);

    $session
        ->withInput($_POST)
        ->flash('error', 'User not found or wrong password.');

    header('Location: /admin/login');
    exit();
}

$session->put('user', $user);
header('Location: /admin/messages');
