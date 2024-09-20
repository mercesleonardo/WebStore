<?php

declare(strict_types = 1);

namespace Core\Database\Query;

use BackedEnum;
use Core\Database\Connector;
use Core\Database\Model;
use Illuminate\Support\Arr;
use InvalidArgumentException;

class Builder
{
    public array $select = [];

    public ?string $from = null;

    public array $wheres = [];

    public array $orderBy = [];

    public array $groupBy = [];

    public ?int $limit = null;

    public ?int $offset = null;

    public array $operators = [
        '=', '<', '>', '<=', '>=', '<>', '!=', '<=>',
        'like', 'like binary', 'not like', 'ilike',
        '&', '|', '^', '<<', '>>', '&~', 'is', 'is not',
        'rlike', 'not rlike', 'regexp', 'not regexp',
        '~', '~*', '!~', '!~*', 'similar to',
        'not similar to', 'not ilike', '~~*', '!~~*',
    ];

    protected array $bindings = [
        'where' => [],
    ];

    public function __construct(
        protected Connector $connector,
        protected Compiler $compiler
    ) {}

    public function select($columns = ['*']): self
    {
        $this->select = is_array($columns) ? $columns : func_get_args();

        return $this;
    }

    public function from($table, string $alias = null): self
    {
        $this->from = $table . ($alias ? " as $alias" : '');

        return $this;
    }

    public function limit(int $limit): self
    {
        $this->limit = $limit;

        return $this;
    }

    public function offset(int $offset): self
    {
        $this->offset = $offset;

        return $this;
    }

    public function orderBy($column, $direction = 'asc'): self
    {
        if (!in_array($direction, ['asc', 'desc'])) {
            throw new InvalidArgumentException('Order direction must be "asc" or "desc"');
        }

        $this->orderBy[] = "$column $direction";

        return $this;
    }

    public function groupBy($column): self
    {
        $this->groupBy[] = $column;

        return $this;
    }

    public function where($column, $operator = null, $value = null, $boolean = 'and'): self
    {
        [$value, $operator] = $this->prepareValueAndOperator($value, $operator, func_num_args() === 2);

        $this->wheres[] = compact('column', 'operator', 'value', 'boolean');

        $this->addBinding($value);

        return $this;
    }

    public function orWhere($column, $operator = null, $value = null): self
    {
        return $this->where($column, $operator, $value, 'or');
    }

    public function get(): array
    {
        return $this
            ->connector
            ->query($this->compiler->compileSelect($this), $this->getBindings())
            ->get();
    }

    public function first(): array | false
    {
        return $this
            ->connector
            ->query($this->compiler->compileSelect($this), $this->getBindings())
            ->first();
    }

    private function prepareValueAndOperator(mixed $value, mixed $operator, bool $useDefault = false): array
    {
        if ($useDefault) {
            return [$operator, '='];
        }

        if ($this->invalidOperatorAndValue($operator, $value)) {
            throw new InvalidArgumentException('Illegal operator and value combination.');
        }

        return [$value, $operator];
    }

    private function invalidOperatorAndValue(mixed $operator, mixed $value): bool
    {
        return is_null($value)
            && in_array($operator, $this->operators, true)
            && !in_array($operator, ['=', '<>', '!=']);
    }

    private function addBinding($value): void
    {
        if (!array_key_exists('where', $this->bindings)) {
            throw new InvalidArgumentException('Invalid binding type.');
        }

        $this->bindings['where'][] = $value instanceof BackedEnum ? $value->value : $value;

    }

    public function getBindings(): array
    {
        return Arr::flatten($this->bindings);
    }

    public function setTableFromModel(Model $model): static
    {
        $this->from($model->getTable());

        return $this;
    }
}
