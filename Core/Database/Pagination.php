<?php

declare(strict_types = 1);

namespace Core\Database;

use Closure;
use Illuminate\Support\Collection;

class Pagination
{
    protected static Closure $currentPageResolver;

    protected static Closure $queryStringResolver;

    protected static Closure $currentPathResolver;

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

        $this->currentPage = $this->setCurrentPage($this->currentPage, $this->pageName);
    }

    public function setCurrentPage(int $currentPage, string $pageName): int
    {
        $currentPage = $currentPage ?: static::resolveCurrentPage($pageName);

        return $this->isValidPageNumber($currentPage) ? $currentPage : 1;
    }

    public function hasMorePages(): bool
    {
        return $this->currentPage() < $this->lastPage();
    }

    public function hasPages(): bool
    {
        return $this->lastPage() > 1;
    }

    public function lastPage()
    {
        return $this->lastPage;
    }

    public function isValidPageNumber($page): bool
    {
        return $page >= 1 && filter_var($page, FILTER_VALIDATE_INT) !== false;
    }

    public function items(): Collection
    {
        return $this->items;
    }

    public function onFirstPage(): bool
    {
        return $this->currentPage <= 1;
    }

    public function firstItem(): float | int | null
    {
        return count($this->items) > 0 ? ($this->currentPage - 1) * $this->perPage + 1 : null;
    }

    public function lastItem(): float | int | null
    {
        return count($this->items) > 0 ? $this->firstItem() + count($this->items) - 1 : null;
    }

    public function currentPage(): int
    {
        return $this->currentPage;
    }

    public function total(): int
    {
        return $this->total;
    }

    public function links() {}

    public static function resolveCurrentPage($pageName = 'page', $default = 1)
    {
        if (isset(static::$currentPageResolver)) {
            return (int) call_user_func(static::$currentPageResolver, $pageName, $default);
        }

        return $default;
    }

    public static function currentPageResolver(Closure $resolver): void
    {
        static::$currentPageResolver = $resolver;
    }

    public static function resolveQueryString($default = null)
    {
        if (isset(static::$queryStringResolver)) {
            return (static::$queryStringResolver)();
        }

        return $default;
    }

    public static function queryStringResolver(Closure $resolver): void
    {
        static::$queryStringResolver = $resolver;
    }

    public static function resolveCurrentPath($default = '/')
    {
        if (isset(static::$currentPathResolver)) {
            return (static::$currentPathResolver)();
        }

        return $default;
    }

    public static function currentPathResolver(Closure $resolver): void
    {
        static::$currentPathResolver = $resolver;
    }
}
