<?php

declare(strict_types = 1);

$title = 'My WebStore';
$heading = 'Home';

$db = \container('db');

$products = $db->query('SELECT * FROM products')->get();

require resource_path('views/index.php');
