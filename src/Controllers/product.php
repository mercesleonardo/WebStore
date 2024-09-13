<?php

declare(strict_types = 1);

use Core\Database\Connector;
use Core\Html\View;

$db = \container(Connector::class);

$product = $db
    ->query('SELECT * FROM products where id = :id', ['id' => $_GET['id']])
    ->first();

echo (new View())
    ->render('product', [
        'title' => $product->name . ' | My WebStore',
        'heading' => 'Product Details',
        'product' => $product,
    ]);