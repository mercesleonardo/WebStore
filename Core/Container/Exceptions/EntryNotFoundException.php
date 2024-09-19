<?php

declare(strict_types = 1);

namespace Core\Container\Exceptions;

use Psr\Container\NotFoundExceptionInterface;
use RuntimeException;

class EntryNotFoundException extends RuntimeException implements NotFoundExceptionInterface
{
    public function __construct(string $concrete)
    {
        parent::__construct("No entry was found for [$concrete] identifier.");
    }
}
