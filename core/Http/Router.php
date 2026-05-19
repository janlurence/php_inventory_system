<?php

declare(strict_types=1);

namespace Core\Http;

final class Router
{
    private array $routes = [];

    public function get(string $uri, array $action): void
    {
        $this->register(HttpMethod::GET, $uri, $action);
    }

    public function post(string $uri, array $action): void
    {
        $this->register(HttpMethod::POST, $uri, $action);
    }

    public function delete(string $uri, array $action): void
    {
        $this->register(HttpMethod::DELETE, $uri, $action);
    }

    public function register(HttpMethod $method, string $uri, array $action): void
    {
        $this->routes[] = new Route(
            method: $method,
            uri: '/' . trim($uri, '/'),
            action: $action,
        );
    }

    public function resolve(Request $request): RouteMatch
    {
        foreach ($this->routes as $route) {
            if ($route->method !== $request->method) {
                continue;
            }

            $parameters = $this->match($route->uri, $request->uri);

            if ($parameters !== null) {
                return new RouteMatch(action: $route->action, parameters: $parameters);
            }
        }

        throw new RouteNotFoundException("No route matched {$request->method->value} {$request->uri}");
    }

    private function match(string $routeUri, string $requestUri): ?array
    {
        $parameterNames = [];
        $pattern = preg_replace_callback('/\{([a-zA-Z_][a-zA-Z0-9_]*)}/', function (array $matches) use (&$parameterNames): string {
            $parameterNames[] = $matches[1];

            return '([^/]+)';
        }, $routeUri);

        if ($pattern === null) {
            return null;
        }

        if (! preg_match('#^' . $pattern . '$#', $requestUri, $matches)) {
            return null;
        }

        array_shift($matches);

        return array_combine($parameterNames, $matches) ?: [];
    }
}
