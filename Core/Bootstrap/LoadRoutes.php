<?php

declare(strict_types = 1);

namespace Core\Bootstrap;

class LoadRoutes
{
    public function handle(): void
    {
        require_once base_path('routes/web.php');
    }
}