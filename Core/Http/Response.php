<?php

declare(strict_types = 1);

namespace Core\Http;

class Response
{
    public const HTTP_OK           = 200;
    public const HTTP_CREATED      = 201;
    public const HTTP_MOVED        = 301;
    public const HTTP_FOUND        = 302;
    public const HTTP_BAD_REQUEST  = 400;
    public const HTTP_UNAUTHORIZED = 401;
    public const HTTP_FORBIDDEN    = 403;
    public const HTTP_NOT_FOUND    = 404;
    public const HTTP_SERVER_ERROR = 500;
}