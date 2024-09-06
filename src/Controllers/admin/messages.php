<?php

declare(strict_types = 1);

use Core\Database\Connector;

$title = 'My Messages';
$heading = 'Home';

$db = \container(Connector::class);

$products = $db->query('SELECT * FROM messages')->get();

require resource_path('views/admin/messages.php');
