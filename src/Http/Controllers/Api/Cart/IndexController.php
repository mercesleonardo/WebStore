<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\Cart;

use Core\Facades\Session;
use Core\Http\Enums\HttpMethod;
use Core\Http\JsonResponse;
use Core\Router\Attributes\Route;

class IndexController
{
    #[Route('/api/cart', HttpMethod::Get)]
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'items' => Session::get('cart', []),
        ]);
    }
}
