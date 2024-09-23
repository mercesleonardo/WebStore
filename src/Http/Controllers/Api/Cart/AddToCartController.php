<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\Cart;

use App\Models\Product;
use Core\Facades\Session;
use Core\Http\Enums\HttpMethod;
use Core\Http\Request;
use Core\Router\Attributes\Route;

class AddToCartController
{
    #[Route('/api/cart/add', HttpMethod::Post)]
    public function __invoke(Request $request)
    {
        $product      = Product::find($request->get('id'));
        $previousCart = collect(Session::get('cart', []));

        if ($previousCart->contains('id', $product->id)) {
            $cart = $previousCart->map(function ($item) use ($product) {
                if ($item['id'] === $product->id) {
                    $item['quantity']++;
                }

                return $item;
            });
        } else {
            $cart = $previousCart->push([
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'image'    => $product->image,
                'quantity' => 1,
            ]);
        }

        Session::put('cart', $cart->all());

        return response()->json([
            'items' => $cart->all(),
        ]);
    }
}
