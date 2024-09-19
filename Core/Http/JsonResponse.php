<?php

declare(strict_types = 1);

namespace Core\Http;

use InvalidArgumentException;
use JsonSerializable;

class JsonResponse extends Response
{
    public function __construct(mixed $content = [], int $statusCode = 200, array $headers = [])
    {
        parent::__construct('', $statusCode, $headers);

        $json = $this->castToJson($content);

        if (!$json) {
            throw new InvalidArgumentException('The given content could not be converted to json. ');
        }

        $this->setContent($json);
        $this->header('Content-Type', 'application/json');
    }

    private function castToJson(mixed $content): string | false
    {
        if ($content instanceof JsonSerializable) {
            return json_encode($content->jsonSerialize());
        }

        return json_encode($content);
    }
}
