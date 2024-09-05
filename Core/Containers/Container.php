<?php

declare(strict_types = 1);

namespace Core\Containers;

use Psr\Container\ContainerInterface;

class Container implements ContainerInterface
{
    private array $instances = [];
    private static Container $instance;

    public function get(string $id)
    {
        if ($this->has($id)) {
            return $this->instances[$id];
        }

        throw new EntryNotFoundException("No entry was found for [$id] identifier");
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->instances);
    }

    public function set(string $id, mixed $instance, bool $overwrite = false): void
    {
        if (!$overwrite && $this->has($id)) {
            return;
        }

        $this->instances[$id] = $instance;
    }

    public static function getInstance(): Container
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}