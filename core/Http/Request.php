<?php

declare(strict_types=1);

namespace Core\Http;

final readonly class Request
{
    public function __construct(
        public HttpMethod $method,
        public string $uri,
        public array $query,
        public array $body,
        public array $server,
        public array $rawQuery = [],
        public array $rawBody = [],
    ) {
    }

    public static function capture(): self
    {
        $server = $_SERVER;
        $method = strtoupper((string) ($server['REQUEST_METHOD'] ?? 'GET'));
        $body = $_POST;

        if ($method === 'POST' && isset($body['_method'])) {
            $method = strtoupper((string) $body['_method']);
        }

        $path = parse_url((string) ($server['REQUEST_URI'] ?? '/'), PHP_URL_PATH);

        return new self(
            method: HttpMethod::from($method),
            uri: '/' . trim((string) $path, '/'),
            query: $_GET,
            body: $body,
            server: $server,
            rawQuery: $_GET,
            rawBody: $_POST,
        );
    }

    public function input(string $key, mixed $default = null): mixed
    {
        if (array_key_exists($key, $this->body)) {
            return self::sanitizeValue($this->body[$key]);
        }

        if (array_key_exists($key, $this->query)) {
            return self::sanitizeValue($this->query[$key]);
        }

        return $default;
    }

    public function string(string $key, string $default = ''): string
    {
        $value = $this->input($key, $default);

        return is_scalar($value) ? self::sanitizeString(trim((string) $value)) : $default;
    }

    public function int(string $key, int $default = 0): int
    {
        return filter_var($this->input($key), FILTER_VALIDATE_INT) ?: $default;
    }

    private static function sanitizeArray(array $data): array
    {
        $sanitized = [];

        foreach ($data as $key => $value) {
            $sanitized[$key] = self::sanitizeValue($value);
        }

        return $sanitized;
    }

    private static function sanitizeValue(mixed $value): mixed
    {
        if (is_array($value)) {
            return self::sanitizeArray($value);
        }

        if (! is_string($value)) {
            return $value;
        }

        return self::sanitizeString($value);
    }

    private static function sanitizeString(string $value): string
    {
        $value = preg_replace('/<script\b[^>]*>.*?<\/script>/is', '', $value) ?? $value;

        return trim(strip_tags($value));
    }
}
