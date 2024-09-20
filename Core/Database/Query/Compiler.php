<?php

declare(strict_types = 1);

namespace Core\Database\Query;

class Compiler
{
    public function compileSelect(Builder $query)
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
        $query = implode(' ', $wheres);

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
}