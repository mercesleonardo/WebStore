<?php

declare(strict_types = 1);

namespace Core;

use Closure;
use Core\Container\Container;
use Core\Database\Pagination;
use Core\Http\Request;
use Core\Session\Session;

class Application extends Container
{
    private array $bootstrappers = [
        Bootstrap\LoadEnvFile::class,
        Bootstrap\ConfigureDatabase::class,
        Bootstrap\StartDatabase::class,
        Bootstrap\StartRouter::class,
        Bootstrap\LoadRoutes::class,
        Bootstrap\StartSession::class,
        Bootstrap\ConfigureAuth::class,
        Bootstrap\StartRedirector::class,
    ];

    public function __construct()
    {
        $this->bootstrap();
    }

    private function bootstrap(): void
    {
        foreach ($this->bootstrappers as $bootstrapper) {
            (new $bootstrapper(
                $this
            ))->handle();
        }
    }

    public function singleton(Closure $closure): void
    {
        $this->set($closure($this));
    }

    public function registerRequest(Request $request): void
    {
        $this->set($request);
        $this->get('redirector')->setRequest($request);
        $this->get(Session::class)->setPreviousUrl($request);

        Pagination::currentPageResolver(fn() => $request->get('page', 1));
        Pagination::queryStringResolver(fn() => $request->get());
        Pagination::currentPageResolver(fn() => $request->path());
    }
}
