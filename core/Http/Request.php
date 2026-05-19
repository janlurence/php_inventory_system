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
        );
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->body[$key] ?? $this->query[$key] ?? $default;
    }

    public function string(string $key, string $default = ''): string
    {
        $value = $this->input($key, $default);

        return is_scalar($value) ? trim((string) $value) : $default;
    }

    public function int(string $key, int $default = 0): int
    {
        return filter_var($this->input($key), FILTER_VALIDATE_INT) ?: $default;
    }
}
