<?php

declare(strict_types = 1);

namespace Core\Interfaces;

interface Renderable
{
    public function render(string $view, array $data = []): string;
}
