<?php

declare(strict_types = 1);

use Core\Auth\Auth;
use Core\Session\Session;
use Core\Validation\Validator;

$validator = new Validator([
    'email'    => ['required', 'email', 'max:100'],
    'password' => ['required', 'string'],
], $_POST);

$session = container(Session::class);
$auth = container(Auth::class);

if ($validator->fails()) {
    $session
        ->withInput($_POST)
        ->withErrors($validator->getErrors());

    redirect('/auth');
}

if (!$auth->attempt($_POST['email'], $_POST['password'])) {
    $session
        ->withInput($_POST)
        ->flash('error', 'User not found or wrong password.');

    redirect('/auth');
}

redirect('/admin/messages');