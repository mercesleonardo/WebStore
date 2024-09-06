<?php

declare(strict_types = 1);

use Core\Database\Connector;

$title = 'Contact Us';
$heading = $title;

$messageWasSent = false;
$failure = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    /** @var Connector $db */
    $db = container(Connector::class);


    $id = $result = $db
        ->query('INSERT INTO messages (name, email, source, message) VALUES (:name, :email, :source, :message)', $_POST)
        ->insert();

    if ($id) {
        $messageWasSent = true;
    } else {
        $failure = true;
    }
}

require resource_path('views/contact.php');