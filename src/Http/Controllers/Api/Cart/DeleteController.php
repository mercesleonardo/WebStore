<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\Cart;

use Core\Facades\Session;
use Core\Http\Enums\HttpMethod;
use Core\Http\Request;
use Core\Http\Response;
use Core\Router\Attributes\Route;

class DeleteController
{
    #[Route('/api/cart/delete', HttpMethod::Delete)]
    public function __invoke(Request $request): Response
    {
        $cart = collect(Session::get('cart', []));

        $cart = $cart
            ->filter(fn($item) => $item['id'] != $request->get('id'))
            ->values()
            ->all();

        Session::put('cart', $cart);

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
