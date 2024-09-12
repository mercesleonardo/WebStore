<?php

declare(strict_types=1);

namespace Core\Html;

class Vite
{
    public function hotFile(): string
    {
        return base_path('/public/hot');
    }

    public function isRunningHot(): bool
    {
        return is_file($this->hotFile);
    }

    public function __invoke(string | array $entrypoints)
    {
        if (is_string($entrypoints)) {
            $entrypoints = [$entrypoints];
        }

        if ($this->isRunningHot()) {

        }
    }
}