<?php

declare(strict_types=1);

namespace App\Middleware;

use Core\Http\Request;
use Core\Http\Response;

interface Middleware
{
    public function handle(Request $request, callable $next): Response;
}