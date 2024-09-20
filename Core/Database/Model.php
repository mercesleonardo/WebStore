<?php

declare(strict_types = 1);

namespace Core\Database;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class Model
{
    protected static Connector $connection;

    protected string $id = 'id';

    protected ?string $table = null;

    protected array $attributes = [];

    public function __construct(
        array $attributes = []
    ) {
        $this->hydrate($attributes);
    }

    public static function resolveConnection(Connector $connection): void
    {
        static::$connection = $connection;
    }

    public function newQuery(): Query\Builder
    {
        return static::$connection->queryBuilder();
    }

    public static function query(): Query\Builder
    {
        $instance = new static();

        return $instance
            ->newQuery()
            ->setTableFromModel($instance);
    }

    public function getTable(): string
    {
        return $this->table ?? Str::snake(Str::pluralStudly(class_basename($this)));
    }

    public function getPrimaryKeyColumn(): string
    {
        return $this->id;
    }

    public function hydrate(array $attributes): static
    {
        $this->attributes = $attributes;

        return $this;
    }

    /** @return Collection<static> */
    public static function all($columns = ['*']): Collection
    {
        $object   = new static();
        $response = $object::query()
            ->select($columns)
            ->get();

        return collect($response)->mapInto(static::class);
    }

    public static function find(int | string $id): static | null
    {
        $object   = new static();
        $response = $object::query()
            ->where($object->getPrimaryKeyColumn(), $id)
            ->limit(1)
            ->first();

        return $response ? $object->hydrate($response) : null;
    }

    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function _set($name, $value): void
    {
        $this->attributes[$name] = $value;
    }
}
