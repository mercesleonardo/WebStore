<?php

declare(strict_types = 1);

use Core\Session\Session;

/** @var Session $session */
$session = container(Session::class);

$title   = 'Contact Us';
$heading = $title;

$success = $session->getFlash('success');
$error   = $session->getFlash('danger');

$sources = [
    'google', 'facebook', 'twitter', 'instagram'
];

require view('contact.php');
