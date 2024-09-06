<?php

declare(strict_types = 1);

use Core\Database\Connector;

$db = \container(Connector::class);

$query = 'SELECT * FROM products where id = :id';
$product = $db->query($query, ['id' => $_GET['id']])->first();

$title = $product->name . ' | My WebStore';
$heading = 'Product Details';

require resource_path('views/product.php');