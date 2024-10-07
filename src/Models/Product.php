<?php

declare(strict_types = 1);

namespace App\Models;

use Core\Database\Pinguim\Model;
use Core\Database\Query\Builder;

/**
 * @property int $id
 * @property string $slug
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
 * @method static Product create(array $data)
 * @method static Builder query()
 */
class Product extends Model {}
