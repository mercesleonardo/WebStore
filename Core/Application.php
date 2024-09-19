<?php

declare(strict_types = 1);

namespace Core;

use Closure;
use Core\Container\Container;
use Core\Http\Request;
use Core\Session\Session;

class Application extends Container
{
    private array $bootstrappers = [
        \Core\Bootstrap\LoadEnvFile::class,
        \Core\Bootstrap\ConfigureDatabase::class,
        \Core\Bootstrap\StartDatabase::class,
        \Core\Bootstrap\StartRouter::class,
        \Core\Bootstrap\LoadRoutes::class,
        \Core\Bootstrap\StartSession::class,
        \Core\Bootstrap\ConfigureAuth::class,
        \Core\Bootstrap\StartRedirector::class,
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
    }
}