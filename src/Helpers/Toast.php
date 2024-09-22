<?php

declare(strict_types = 1);

namespace App\Helpers;

use Core\Facades\Session;

readonly class Toast
{
    public const string SUCCESS = 'success';
    public const string ERROR   = 'error';
    public const string INFO    = 'info';
    public const string WARNING = 'warning';

    public function __construct(
        public string $message,
        public string $type
    ) {}

    public function flashMessage(): void
    {
        Session::flash('toast', $this);
    }

    public static function success(string $message): void
    {
        (new self($message, self::SUCCESS))->flashMessage();
    }

    public static function error(string $message): void
    {
        (new self($message, self::ERROR))->flashMessage();
    }

    public static function info(string $message): void
    {
        (new self($message, self::INFO))->flashMessage();
    }

    public static function warning(string $message): void
    {
        (new self($message, self::WARNING))->flashMessage();
    }
}
