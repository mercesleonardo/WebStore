<?php

declare(strict_types = 1);

namespace App\Models;

use Core\Database\Pinguim\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $quantity
 * @property string $description
 * @property string|null $image
 * @property int $price
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @method static Product find(int | string $id)
 * @method static Product[] all()
 */
class Product extends Model {}
