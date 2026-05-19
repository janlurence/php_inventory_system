<?php

declare(strict_types=1);

namespace Core\Http;

final readonly class RouteMatch
{
    public function __construct(
        public array $action,
        public array $parameters = [],
    ) {
    }
}
