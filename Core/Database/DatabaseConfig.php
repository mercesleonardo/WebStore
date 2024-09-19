<?php

declare(strict_types = 1);

namespace Core\Database;

class DatabaseConfig
{
    private array $config;

    private string $username;

    private string $password;

    public function __construct()
    {
        $config = require base_path('config/database.php');

        [
            'username' => $username,
            'password' => $password
        ] = $config;

        unset($config['username'], $config['password']);

        $this->config   = $config;
        $this->username = $username;
        $this->password = $password;
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}