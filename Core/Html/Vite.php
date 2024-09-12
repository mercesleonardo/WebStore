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

    public function __invoke(string|array $entrypoints): string
    {
        if (is_string($entrypoints)) {
            $entrypoints = [$entrypoints];
        }

        if ($this->isRunningHot()) {
            array_unshift($entrypoints, '@vite/client');

            return $this->hot($entrypoints);
        }

        return '';
    }

    private function hot(array $entrypoints)
    {
    }

    private function makeTagForChunk(string $path)
    {

    }

    private function hotAsset(string $entrypoint): string
    {
        return rtrim(file_get_contents($this->hotFile())) . '/' . $entrypoint;
    }

    private function isCss(string $path): bool
    {
        return preg_match('/\.(css|less|sass|scss|styl|stylus|pcss|postcss)$/', $path) === 1;
    }
}
