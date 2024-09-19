<?php

declare(strict_types = 1);

namespace Core\Validation\Rules;

use Egulias\EmailValidator\EmailLexer;
use Egulias\EmailValidator\Result\InvalidEmail;
use Egulias\EmailValidator\Validation\EmailValidation;

class FilterEmailRule implements EmailValidation
{
    public function isValid(string $email, EmailLexer $emailLexer): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public function getError(): ?InvalidEmail
    {
        return null;
    }

    public function getWarnings(): array
    {
        return [];
    }
}