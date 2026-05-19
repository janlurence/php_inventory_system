<?php

declare(strict_types=1);

namespace Core\Http;

final readonly class Route
{
    public function __construct(
        public HttpMethod $method,
        public string $uri,
        public array $action,
    ) {
    }
}
