<?php

declare(strict_types = 1);

use Core\Containers\Container;
use Core\Database\Connector;

$db = \container('db');

$product = $db->query('SELECT * FROM products where id = :id', ['id' => $_GET['id']])->first();

$title = $product->name . ' | My WebStore';
$heading = 'Product Details';

require resource_path('views/product.php');