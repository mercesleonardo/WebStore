<?php

namespace Core\Containers;

use Psr\Container\NotFoundExceptionInterface;

class EntryNotFoundException extends \RuntimeException implements NotFoundExceptionInterface
{

    /**
     * @param string $string
     */
    public function __construct(string $string)
    {
    }
}