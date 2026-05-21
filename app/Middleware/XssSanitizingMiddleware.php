<?php

declare(strict_types=1);

namespace App\Middleware;

use Core\Http\Request;
use Core\Http\Response;

final readonly class XssSanitizingMiddleware implements Middleware
{
    public function handle(Request $request, callable $next): Response
    {
        $sanitizedRequest = new Request(
            method: $request->method,
            uri: $request->uri,
            query: $this->sanitizeArray($request->query),
            body: $this->sanitizeArray($request->body),
            server: $request->server,
        );

        return $next($sanitizedRequest);
    }

    private function sanitizeArray(array $data): array
    {
        $sanitized = [];

        foreach ($data as $key => $value) {
            $sanitized[$key] = $this->sanitizeValue($value);
        }

        return $sanitized;
    }

    private function sanitizeValue(mixed $value): mixed
    {
        if (is_array($value)) {
            return $this->sanitizeArray($value);
        }

        if (! is_string($value)) {
            return $value;
        }

        return $this->sanitizeString($value);
    }

    private function sanitizeString(string $value): string
    {
        $value = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $value) ?? $value;
        $value = strip_tags($value);

        return trim($value);
    }
}