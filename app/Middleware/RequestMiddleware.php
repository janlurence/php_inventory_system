<?php
declare(strict_type=1);

namespace App\Middleware;

final readonly class RequestMiddleware
{
    public function __construct(
        public Middleware $middleware,
    ) {
    }
}