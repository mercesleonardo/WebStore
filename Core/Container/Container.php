<?php

declare(strict_types = 1);

namespace Core\Container;

use Core\Container\Exceptions\DependencyNotInstantiableException;
use Core\Container\Exceptions\EntryNotFoundException;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;

class Container implements ContainerInterface
{
    private array $instances = [];

    private static Container $instance;

    public function get(string $id)
    {
        if ($this->has($id)) {
            return $this->instances[$id];
        }

        return $this->build($id);
    }

    public function has(string $id): bool
    {
        return array_key_exists($id, $this->instances);
    }

    public function set($abstract, $concrete = null): void
    {
        if ($concrete === null) {
            $concrete = $abstract;
        }

        if (is_object($abstract)) {
            $abstract = get_class($abstract);
        }

        $this->instances[$abstract] = $concrete;
    }

    public function build($concrete)
    {
        try {
            $reflection = new ReflectionClass($concrete);
        } catch (ReflectionException) {
            throw new EntryNotFoundException($concrete);
        }

        if (!$reflection->isInstantiable()) {
            throw new DependencyNotInstantiableException($concrete);
        }

        $constructor = $reflection->getConstructor();

        if (is_null($constructor)) {
            return new $concrete;
        }

        $dependencies = $constructor->getParameters();

        $instances = [];

        /** @var \ReflectionParameter $dependency */
        foreach ($dependencies as $dependency) {
            $dependency = $dependency->getType()->getName();

            if ($this->has($dependency)) {
                $instances[] = $this->get($dependency);
                continue;
            }

            $instances[] = $this->build($dependency);
        }

        return $reflection->newInstanceArgs($instances);
    }

    public static function getInstance(): Container
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }
}