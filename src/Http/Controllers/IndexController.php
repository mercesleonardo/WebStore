<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Models\Product;
use Core\Html\View;
use Core\Router\Attributes\Route;

class IndexController
{
    #[Route('/')]
    public function __invoke(): string
    {
        $products = Product::query()->paginate(8);

        return (new View())
            ->render('index', [
                'title'    => 'My GameStore',
                'heading'  => 'Home',
                'products' => $products,
            ]);
    }
}
