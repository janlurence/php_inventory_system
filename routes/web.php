<?php

declare(strict_types=1);

use App\Controllers\ProductController;
use Core\Http\Router;

return static function (Router $router): void {
    $router->get('/', [ProductController::class, 'index']);
    $router->get('/products', [ProductController::class, 'index']);
    $router->get('/products/create', [ProductController::class, 'create']);
    $router->post('/products', [ProductController::class, 'store']);
    $router->get('/products/{id}', [ProductController::class, 'show']);
    $router->get('/products/{id}/edit', [ProductController::class, 'edit']);
    $router->get('/products/{id}/delete', [ProductController::class, 'confirmDestroy']);
    $router->post('/products/{id}', [ProductController::class, 'update']);
    $router->delete('/products/{id}', [ProductController::class, 'destroy']);
};
