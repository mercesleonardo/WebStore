<?php

declare(strict_types = 1);

use Core\Database\Connector;
use Core\Validation\Validator;

$title = 'Contact Us';
$heading = $title;

$messageWasSent = false;
$failure = false;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validator = new Validator([
        'name'    => ['required', 'min:3', 'max:100'],
        'email'   => ['required', 'email', 'max:100'],
        'source'  => ['required'],
        'message' => ['required', 'max:255'],
    ], $_POST);

    if ($validator->passes()) {
        /** @var Connector $db */
        $db = container(Connector::class);

        $id = $db
            ->query('INSERT INTO messages (name, email, source, message) VALUES (:name, :email, :source, :message)', $_POST)
            ->insert();

        $_POST = [];

        if ($id === false) {
            $failure = true;
        } else {
            $messageWasSent = true;
        }
    } else {
        $errors = $validator->getErrors();
    }
}

require resource_path('views/contact.php');