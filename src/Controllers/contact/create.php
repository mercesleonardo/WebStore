<?php

declare(strict_types = 1);

use Core\Html\View;
use Core\Session\Session;

/** @var Session $session */
$session = container(Session::class);

$sources = [
    'google', 'facebook', 'twitter', 'instagram',
];

echo (new View())
    ->render('contact', [
        'title'   => 'Contact Us',
        'heading' => 'Contact Us',
        'success' => $session->getFlash('success'),
        'error'   => $session->getFlash('danger'),
        'sources' => $sources,
    ]);