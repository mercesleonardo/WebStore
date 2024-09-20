<?php

declare(strict_types = 1);

namespace Core\Database\Pinguim;

use Core\Database\Query\Builder;
use Illuminate\Support\Collection;

class ModelQuery
{
    public function __construct(protected Model $model) {}

    public function query(): Builder
    {
        return $this
            ->model
            ->newQuery()
            ->setModelProperties($this->model);
    }

    public function all($columns = ['*']): Collection
    {
        return $this
            ->query()
            ->select($columns)
            ->get();
    }

    public function find(int | string $id): ?Model
    {
        $model = $this
            ->query()
            ->where($this->model->getPrimaryKeyColumn(), $id)
            ->limit(1)
            ->first();

        return $model ? $this->model->hydrate($model, true) : null;
    }

    public function create(array $attributes): Model
    {
        $this
            ->model
            ->fill($attributes)
            ->touchTimestamps();

        $id = $this
            ->query()
            ->insert($attributes);

        return $this->model->setNewId($id)->setExists();
    }
}