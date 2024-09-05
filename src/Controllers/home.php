<?php

declare(strict_types = 1);

use Core\Database\Connector;
use Core\Database\DatabaseConfig;

$title = 'My WebStore';
$heading = 'Home';

$dbConfig = new Connector(DatabaseConfig::getInstance());

$products = $dbConfig->query('SELECT * FROM products')->get();

require resource_path('views/index.php');
