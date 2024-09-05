<?php

declare(strict_types = 1);

$db = \container('db');

$query = 'SELECT * FROM products where id = :id';
$product = $db->query($query, ['id' => $_GET['id']])->first();

$title = $product->name . ' | My WebStore';
$heading = 'Product Details';

require resource_path('views/product.php');