<?php

declare(strict_types = 1);

namespace Core\Session;

class PrepareDataForFlash
{
    protected array $except = [
        'password',
        'password_confirmation',
    ];

    public function __construct(
        protected array $data
    ) {}

    public function handle(): array
    {
        $data = [];

        foreach ($this->data as $key => $value) {
            if (!in_array($key, $this->except)) {
                $data[$key] = $value;
            }
        }

        return $data;
    }
}
