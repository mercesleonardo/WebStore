<?php

declare(strict_types = 1);

namespace Core\Validation;

class Validator
{
    use Concerns\ValidatesAttributes;
    use Concerns\ValidatesEmail;

    private array $messages = [];

    private array $errors = [];

    public function __construct(
        private array $rules,
        private array $data,
    ) {
        $this->messages = require resource_path('lang/validation.php');
    }

    public function passes(): bool
    {
        foreach ($this->rules as $attribute => $rules) {
            $this->validateAttribute($attribute, $rules);
        }

        return empty($this->errors);
    }

    public function fails(): bool
    {
        return ! $this->passes();
    }

    public function validate(): true
    {
        if ($this->fails()) {
            throw new ValidationException($this);
        }

        return true;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function validateAttribute(string $attribute, array $rules): void
    {
        foreach ($rules as $rule) {
            [$rule, $parameter] = $this->parseRule($rule);

            $value = $this->data[$attribute] ?? null;

            $method = 'validate' . ucfirst($rule);

            if (!$this->{$method}($value, $parameter)) {
                $this->errors[$attribute][] = $this->getErrorMessage($attribute, $rule, $parameter);
            }
        }
    }

    private function parseRule(mixed $rule): array
    {
        $segments = explode(':', $rule);

        return [
            $segments[0],
            $segments[1] ?? null,
        ];
    }

    private function getErrorMessage(string $attribute, mixed $rule, mixed $parameter): string
    {
        return str_replace(
            [':attribute', ':parameter'],
            [$attribute, $parameter],
            $this->messages[$rule]
        );
    }
}