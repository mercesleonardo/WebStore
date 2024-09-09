<?php

declare(strict_types = 1);

$title   = 'Contact Us';
$heading = $title;

$messageWasSent = false;
$failure = false;

$errors = [];

require view('contact.php');
