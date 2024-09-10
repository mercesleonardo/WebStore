<?php

declare(strict_types = 1);

namespace Core\Validation\Concerns;

trait ValidatesAttributes
{
    protected function validateRequired($value): bool
    {
        if (is_null($value)) {
            return false;
        } else if (is_string($value) && trim($value) === '') {
            return false;
        } else if (is_countable($value) && count($value) < 1) {
            return false;
        }

        return true;
    }

    protected function validateMax($value, $parameter): bool
    {
        if (is_countable($value)) {
            return count($value) <= $parameter;
        }

        return strlen($value) <= $parameter;
    }

    protected function validateMin($value, $parameter): bool
    {
        if (is_countable($value)) {
            return count($value) >= $parameter;
        }

        return strlen($value) >= $parameter;
    }

    protected function validateString($value): bool
    {
        return is_string($value);
    }


}