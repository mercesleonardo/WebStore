<?php

declare(strict_types = 1);

$title   = 'Contact Us';
$heading = $title;

$messageWasSent = false;
$failure = false;

$sources = [
    'google', 'facebook', 'twitter', 'instagram'
];

require view('contact.php');
