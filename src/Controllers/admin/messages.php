<?php

declare(strict_types = 1);

use Core\Database\Connector;
use Core\Html\View;

$title   = 'My Messages';
$heading = $title;

$db = \container(Connector::class);

$messages = $db
    ->query('SELECT * FROM messages')
    ->get();

echo (new View())
    ->render('admin/messages', [
        'title'    => $title,
        'heading'  => $heading,
        'messages' => $messages
    ]);