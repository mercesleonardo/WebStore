<?php

declare(strict_types = 1);

namespace Core\Database\Query;

class Compiler
{
    public function compileSelect(Builder $query): string
    {
        $select = $query->select ?: ['*'];

        $sql = 'SELECT ' . implode(', ', $select) . ' FROM ' . $query->from;

        if (!empty($query->wheres)) {
            $sql .= ' WHERE ' . $this->compileWheres($query);
        }

        if (!empty($query->groupBy)) {
            $sql .= ' GROUP BY ' . implode(', ', $query->groupBy);
        }

        if (!empty($query->orderBy)) {
            $sql .= ' ORDER BY ' . implode(', ', $query->orderBy);
        }

        if ($query->limit) {
            $sql .= ' LIMIT ' . $query->limit;
        }

        if ($query->offset) {
            $sql .= ' OFFSET ' . $query->offset;
        }

        return trim($sql);
    }

    private function compileWheres(Builder $query): string
    {
        $wheres = $this->compileWheresToArray($query);
        $query  = implode(' ', $wheres);

        return $this->removeLeadingBoolean($query);
    }

    private function compileWheresToArray(Builder $query): array
    {
        return array_map(function (array $where) {
            return "{$where['boolean']} {$where['column']} {$where['operator']} ?";
        }, $query->wheres);
    }

    private function removeLeadingBoolean(string $query): string
    {
        return preg_replace('/and |or /i', '', $query, 1);
    }

    public function compileInsert(Builder $query): string
    {
        $columns  = implode(', ', $query->columns);
        $bindings = implode(', ', array_fill(0, count($query->columns), '?'));

        return <<<SQL
            INSERT INTO {$query->table} ({$columns}) VALUES ({$bindings})
        SQL;
    }

    public function compileUpdate(Builder $query): string
    {
        $sql = 'UPDATE ' . $query->table;

        $sql .= ' SET ' . collect($query->columns)
            ->map(fn($column): string => "$column = ?")
            ->implode(', ');

        if (!empty($query->wheres)) {
            $sql .= ' WHERE ' . $this->compileWheres($query);
        }

        return trim($sql);
    }

    public function compileDelete(Builder $query): string
    {
        $sql = 'DELETE FROM ' . $query->table;

        if (!empty($query->wheres)) {
            $sql.= ' WHERE ' . $this->compileWheres($query);
        }

        return trim($sql);
    }
}
