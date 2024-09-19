<?php

declare(strict_types = 1);

namespace Core\Router\Loader;

use FilesystemIterator;
use RecursiveCallbackFilterIterator;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use ReflectionClass;
use SplFileInfo;

class RouteLoader
{
    private array $routes = [];

    private string $controllersDir;

    public function __construct()
    {
        $this->controllersDir = (require base_path('config/app.php'))['controller_path'];

        $this->loadClasses();
    }

    private function loadClasses(): void
    {
        $files = $this->getFileList();

        foreach ($files as $file) {
            if ($file->getExtension() !== 'php') {
                continue;
            }

            $path = $file->getPathname();
            $path = substr($path, strpos($path, 'src'));
            $path = str_replace(['src', '/', '.php'], ['App', '\\', ''], $path);

            if (!class_exists($path) || (new ReflectionClass($path))->isAbstract()) {
                continue;
            }

            $this->routes[] = $path;
        }
    }

    /** @return SplFileInfo[] */
    private function getFileList(): array
    {
        $files = iterator_to_array(new RecursiveIteratorIterator(
            new RecursiveCallbackFilterIterator(
                new RecursiveDirectoryIterator($this->controllersDir, FilesystemIterator::SKIP_DOTS | FilesystemIterator::FOLLOW_SYMLINKS),
                fn(SplFileInfo $current) => !str_starts_with($current->getBasename(), '.')
            ),
            RecursiveIteratorIterator::SELF_FIRST
        ));

        return array_filter($files, fn(SplFileInfo $file) => $file->isFile());
    }

    public function getRoutes(): array
    {
        return $this->routes;
    }
}
