<?php

declare(strict_types = 1);

use Core\Html\View;
use Core\Session\Session;

$error = container(Session::class)->getFlash('error');

echo (new View('login'))
    ->render('auth/index', [
        'title' => 'Admin Login',
        'error' => $error
    ]);