<?php

declare(strict_types = 1);

namespace Core\Validation;

use Exception;

class ValidationException extends Exception
{
    public function __construct(
        protected Validator $validator
    ) {
        parent::__construct('The given data was invalid.');
    }

    public function getErrors(): array
    {
        return $this->validator->getErrors();
    }
}
