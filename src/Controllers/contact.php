<?php

declare(strict_types = 1);

use Core\Database\Connector;

$title = 'Contact Us';
$heading = $title;

$messageWasSent = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    /** @var Connector $db */
    $db = container(Connector::class);

    try {
        $result = $db
            ->query('INSERT INTO messages (name, email, source, message) VALUES (:name, :email, :source, :message)', $_POST)
            ->insert();

        $messageWasSent = true;
    } catch (Exception) {
    }
}

require resource_path('views/contact.php');