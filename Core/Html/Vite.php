<?php

declare(strict_types = 1);

namespace Core\Html;

class Vite
{
    protected array $manifest = [];

    public function hotFile(): string
    {
        return base_path('/public/hot');
    }

    public function isRunningHot(): bool
    {
        return is_file($this->hotFile());
    }

    public function __invoke(string | array $entrypoints): string
    {
        if (is_string($entrypoints)) {
            $entrypoints = [$entrypoints];
        }

        if ($this->isRunningHot()) {
            array_unshift($entrypoints, '@vite/client');

            return $this->hot($entrypoints);
        }

        return $this->prod($entrypoints);
    }

    private function hot(array $entrypoints): string
    {
        $entrypoints = array_map(fn($entrypoint) => $this->makeTagForChunk($this->hotAsset($entrypoint)), $entrypoints);

        return implode(PHP_EOL, $entrypoints);
    }

    private function makeTagForChunk(string $path): string
    {
        if ($this->isCss($path)) {
            return $this->makeCssTag($path);
        }

        return $this->makeJavascriptTag($path);
    }

    private function hotAsset(string $entrypoint): string
    {
        return rtrim(file_get_contents($this->hotFile())) . '/' . $entrypoint;
    }

    private function isCss(string $path): bool
    {
        return preg_match('/\.(css|less|sass|scss|styl|stylus|pcss|postcss)$/', $path) === 1;
    }

    private function makeCssTag(string $path): string
    {
        $attributes = $this->parseAttributes([
            'rel'  => 'stylesheet',
            'href' => $path,
        ]);

        return '<link ' . implode(' ', $attributes) . ' />';
    }

    private function makeJavascriptTag(string $path): string
    {
        $attributes = $this->parseAttributes([
            'type' => 'module',
            'src'  => $path,
        ]);

        return '<script ' . implode(' ', $attributes) . '></script>';
    }

    private function parseAttributes(array $attributes): array
    {
        return array_map(function ($key, $value) {
            return $key . '="' . $value . '"';
        }, array_keys($attributes), $attributes);
    }

    private function prod(array $entrypoints): string
    {
        $this->manifest();

        $tags = [];

        foreach ($entrypoints as $entrypoint) {
            $chunk  = $this->chunk($entrypoint);
            $tags[] = $this->makeTagForChunk('/build/' . $chunk['file']);
        }

        [$stylesheets, $scripts] = $this->separateStylesheetsAndScripts($tags);

        return implode(PHP_EOL, $stylesheets) . PHP_EOL
            . implode(PHP_EOL, $scripts);
    }

    private function manifest(): void
    {
        $path = base_path('/public/build/manifest.json');

        if (!is_file($path)) {
            throw new ViteException('Manifest file not found');
        }

        $this->manifest = json_decode(file_get_contents($path), true);
    }

    private function chunk(string $entrypoint): array
    {
        if (!isset($this->manifest[$entrypoint])) {
            throw new ViteException("Chunk {$entrypoint} not found in manifest");
        }

        return $this->manifest[$entrypoint];
    }

    private function separateStylesheetsAndScripts(array $tags): array
    {
        $css = [];
        $js  = [];

        foreach (array_unique($tags) as $tag) {
            if ($this->isCss($tag)) {
                $css[] = $tag;
            } else {
                $js[] = $tag;
            }
        }

        return [$css, $js];
    }
}
