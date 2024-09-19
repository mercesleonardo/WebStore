<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use Core\Database\Connector;
use Core\Html\View;
use Core\Router\Attributes\Route;

class IndexController
{
    #[Route('/')]
    public function __invoke(Connector $db): string
    {
        $products = $db
            ->query('SELECT * FROM products')
            ->get();

        return (new View())
            ->render('index', [
                'title'    => 'My WebStore',
                'heading'  => 'Home',
                'products' => $products,
            ]);
    }
}
