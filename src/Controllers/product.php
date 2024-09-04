<?php

declare(strict_types = 1);

use Core\Database\Connector;

$product = (new Connector())->query('SELECT * FROM products where id = 1')->first();

$title = $product->name . ' | My WebStore';
$heading = 'Product Details';

require resource_path('views/product.php');