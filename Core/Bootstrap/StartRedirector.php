<?php

declare(strict_types = 1);

namespace Core\Bootstrap;

use Core\Application;
use Core\Http\RedirectResponse;
use Core\Session\Session;

class StartRedirector
{
    public function __construct(
        protected Application $app
    ) {}

    public function handle(): void
    {
        $redirector = new RedirectResponse();
        $redirector->setSession($this->app->get(Session::class));

        $this->app->set('redirector', $redirector);
    }
}
