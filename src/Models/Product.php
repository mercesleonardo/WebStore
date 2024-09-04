<?php

declare(strict_types = 1);

namespace App\Models;

class Product
{
    public static function all(): array
    {
        return [
            [
                'name' => 'Xbox',
                'price' => 499.99,
                'is_available' => true,
            ],
            [
                'name' => 'PlayStation 5',
                'price' => 649.99,
                'is_available' => false,
            ],
            [
                'name' => 'Nintendo Switch',
                'price' => 499.99,
                'is_available' => true,
            ]
        ];
    }
}