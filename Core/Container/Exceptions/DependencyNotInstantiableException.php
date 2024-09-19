<?php

declare(strict_types = 1);

namespace Core\Container\Exceptions;

use Exception;

class DependencyNotInstantiableException extends Exception
{
    public function __construct(string $concrete)
    {
        parent::__construct('Dependency ' . $concrete . ' is not instantiable.');
    }
}
