<?php

namespace Core\Validation\rules;

use Egulias\EmailValidator\EmailLexer;
use Egulias\EmailValidator\Result\InvalidEmail;
use Egulias\EmailValidator\Validation\EmailValidation;

class FilterEmailRule implements EmailValidation
{
    private array $warnings = array();

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
        return array();
    }
}