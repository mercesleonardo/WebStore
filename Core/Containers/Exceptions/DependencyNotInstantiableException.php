<?php

declare(strict_types = 1);

namespace Core\Containers\Exceptions;

use Exception;

class DependencyNotInstantiableException extends Exception
{
    public function __construct(string $concrete)
    {
        parent::__construct('Dependency' . $concrete . 'cannot be instantiated');
    }
}