<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use Core\Database\Connector;
use Core\Html\View;
use Core\Http\Request;
use Core\Router\Attributes\Route;

class ProductController
{
    #[Route('/product')]
    public function __invoke(Request $request, Connector $db): string
    {
        $product = $db
            ->query('SELECT * FROM products where id = :id', ['id' => $request->get('id')])
            ->first();

        return (new View())
            ->render('product', [
                'title'   => $product->name . ' | My WebStore',
                'heading' => 'Product Details',
                'product' => $product,
            ]);
    }
}
