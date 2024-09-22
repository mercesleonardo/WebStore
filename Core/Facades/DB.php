<?php

declare(strict_types = 1);

namespace Core\Facades;

use Core\Database\Query\Builder;
use Core\Facade;

/**
 * @method static Builder table(string $table)
 * @method static Builder select($columns = ['*'])
 * @method static Builder from($table, string $alias = null)
 */
class DB extends Facade
{
    public static function getFacadeAccessor(): string
    {
        return Builder::class;
    }
}