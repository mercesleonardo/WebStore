<?php

declare(strict_types = 1);

namespace Core\Database;

use Illuminate\Support\Collection;

class Pagination
{
    protected string $pageName = 'page';

    protected int $onEachSide = 3;

    protected int $lastPage;

    public function __construct(
        protected Collection $items,
        protected int $total,
        protected int $perPage,
        protected int $currentPage,
        protected string $path = '/',
    ) {
        $this->lastPage = max((int) ceil($this->total / $this->perPage), 1);
        $this->path     = $this->path !== '/' ? rtrim($this->path, '/') : $this->path;
    }
}