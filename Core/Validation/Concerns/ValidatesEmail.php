<?php

declare(strict_types = 1);

namespace Core\Validation\Concerns;

use Core\Validation\Rules\FilterEmailRule;
use Egulias\EmailValidator\EmailValidator;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;

trait ValidatesEmail
{
    protected function validateEmail($value): bool
    {
        $validator = new EmailValidator();

        $multipleValidations = new MultipleValidationWithAnd([
            new RFCValidation(),
            new FilterEmailRule(),
        ]);

        return $validator->isValid($value, $multipleValidations);
    }
}
