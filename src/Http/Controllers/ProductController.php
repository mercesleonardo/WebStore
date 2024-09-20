<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Models\Product;
use Core\Html\View;
use Core\Http\Request;
use Core\Router\Attributes\Route;

class ProductController
{
    #[Route('/product')]
    public function __invoke(Request $request): string
    {
        $product = Product::find($request->get('id'));

        return (new View())
            ->render('product', [
                'title'   => $product->name . ' | My WebStore',
                'heading' => 'Product Details',
                'product' => $product,
            ]);
    }
}
