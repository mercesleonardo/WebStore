<?php

declare(strict_types = 1);

namespace Core\Database\Pinguim;

use Carbon\Carbon;
use Core\Database\Connector;
use Core\Database\Exceptions\MassAssignmentException;
use Core\Database\Query;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

abstract class Model
{
    protected const CREATED_AT = 'created_at';
    protected const UPDATED_AT = 'updated_at';

    protected static Connector $connection;

    protected string $id = 'id';

    protected ?string $table = null;

    protected array $attributes = [];

    protected array $original = [];

    protected bool $exits = false;

    public bool $timestamps = true;

    protected array $fillable = [];

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

    public function modelQuery(): ModelQuery
    {
        return new ModelQuery($this);
    }

    public function getTable(): string
    {
        return $this->table ?? Str::snake(Str::pluralStudly(class_basename($this)));
    }

    public function getPrimaryKeyColumn(): string
    {
        return $this->id;
    }

    public function hydrate(array $attributes, bool $exists = false): static
    {
        $this->attributes = $attributes;
        $this->exits      = $exists;

        $this->syncOriginal();

        return $this;
    }

    public function fill(array $attributes): static
    {
        foreach (array_keys($attributes) as $attribute) {
            if (!in_array($attribute, $this->fillable)) {
                throw new MassAssignmentException("You are trying to assign a value to a non-fillable attribute: [$attribute]");
            }

            $this->attributes[$attribute] = $attributes[$attribute];
        }

        return $this;
    }

    public function exists(): bool
    {
        return $this->exits;
    }

    public function setExists(): static
    {
        $this->exits = true;

        return $this;
    }

    public function touchTimestamps(): static
    {
        $this->touchCreatedAt();
        $this->touchUpdatedAt();

        return $this;
    }

    public function touchCreatedAt(): void
    {
        if (!is_null(static::CREATED_AT) && $this->timestamps) {
            $this->attributes[static::CREATED_AT] = Carbon::now();
        }
    }

    public function touchUpdatedAt(): void
    {
        if (!is_null(static::UPDATED_AT) && $this->timestamps) {
            $this->attributes[static::UPDATED_AT] = Carbon::now();
        }
    }

    public function setNewId(int | string $id): static
    {
        $this->attributes[$this->getPrimaryKeyColumn()] = $id;

        return $this;
    }

    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set($name, $value): void
    {
        $this->attributes[$name] = $value;
    }

    public static function __callStatic(string $name, array $arguments)
    {
        return (new static())->modelQuery()->$name(...$arguments);
    }

    public function syncOriginal(): static
    {
        $this->original = $this->attributes;

        return $this;
    }

    public function save(): bool
    {
        $response = !$this->exits
            ? $this->performInsert()
            : $this->performUpdate();

        if ($response) {
            $this->syncOriginal();
        }

        return $response;
    }

    public function update(array $attributes): bool
    {
        return $this->fill($attributes)->save();
    }

    private function performInsert(): bool
    {
        $this->touchTimestamps();

        $id = $this
            ->newQuery()
            ->setModelProperties($this)
            ->insert($this->attributes);

        $this
            ->setNewId($id)
            ->setExists();

        return true;
    }

    private function performUpdate(): bool
    {
        if (!$this->exits) {
            return false;
        }

        $dirty = $this->getDirty();

        if (count($dirty) === 0) {
            return true;
        }

        $this->touchUpdatedAt();

        return $this
            ->newQuery()
            ->setModelProperties($this)
            ->where($this->getPrimaryKeyColumn(), $this->attributes[$this->getPrimaryKeyColumn()])
            ->update($dirty);
    }

    public function getDirty(): array
    {
        $dirty = [];

        foreach ($this->attributes as $key => $value) {
            if ($key === $this->getPrimaryKeyColumn()) {
                continue;
            }

            if (!array_key_exists($key, $this->original) || $value !== $this->original[$key]) {
                $dirty[$key] = $value;
            }
        }

        return $dirty;
    }

    public function newCollection(array $models): Collection
    {
        return collect($models)
            ->map(fn($model) => (new static())->hydrate($model, true));
    }

    public function newInstance(array $data, bool $exists = false): static
    {
        return (new static())->hydrate($data, $exists);
    }

    public function destroy(): bool
    {
        if (!$this->exits) {
            return false;
        }

        $response = $this
            ->newQuery()
            ->setModelProperties($this)
            ->where($this->getPrimaryKeyColumn(), $this->attributes[$this->getPrimaryKeyColumn()])
            ->delete();

        if ($response) {
            $this->exits = false;
        }

        return $response;
    }
}
