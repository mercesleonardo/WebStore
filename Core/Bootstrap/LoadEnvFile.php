<?php

declare(strict_types = 1);

namespace Core\Bootstrap;

use Dotenv\Dotenv;

class LoadEnvFile
{
    public function handle(): void
    {
        $dotenv = Dotenv::createImmutable(base_path());
        $dotenv->load();
    }
}
