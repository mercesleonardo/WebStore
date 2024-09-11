<?php

declare(strict_types = 1);

use Core\Auth\Auth;

$auth = container(Auth::class);
$auth->logout();

redirect('/');