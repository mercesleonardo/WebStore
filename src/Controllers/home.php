<?php

declare(strict_types = 1);

use Core\Database\Connector;
use Core\Html\View;

$db = \container(Connector::class);

$products = $db
    ->query('SELECT * FROM products')
    ->get();

echo (new View())
    ->render('index', [
        'title'    => 'My WebStore',
        'heading'  => 'Home',
        'products' => $products,
    ]);