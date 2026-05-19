<?php

declare(strict_types=1);

namespace Core;

use Core\Container\Container;
use Core\Http\Request;
use Core\Http\Response;
use Core\Http\RouteNotFoundException;
use Core\Http\Router;
use Throwable;

final readonly class Application
{
    public function __construct(
        private Container $container,
        private Router $router,
    ) {
    }

    public function handle(Request $request): Response
    {
        try {
            $match = $this->router->resolve($request);
            [$controllerClass, $method] = $match->action;
            $controller = $this->container->get($controllerClass);
            $result = $controller->{$method}($request, ...array_values($match->parameters));

            return $result instanceof Response ? $result : Response::html((string) $result);
        } catch (RouteNotFoundException) {
            return Response::html('<h1>404 Not Found</h1><p>The page you requested does not exist.</p>', 404);
        } catch (Throwable $exception) {
            return Response::html('<h1>500 Server Error</h1><p>' . htmlspecialchars($exception->getMessage()) . '</p>', 500);
        }
    }
}
