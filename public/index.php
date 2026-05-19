<?php

declare(strict_types=1);

use App\Repositories\PdoProductRepository;
use App\Repositories\ProductRepositoryInterface;
use Core\Application;
use Core\Container\Container;
use Core\Contracts\DatabaseDriver;
use Core\Database\Connection;
use Core\Database\MySQLDriver;
use Core\Database\SQLiteDriver;
use Core\Http\Request;
use Core\Http\Router;
use Core\View\Engine;

require dirname(__DIR__) . '/vendor/autoload.php';

$appConfig = require dirname(__DIR__) . '/config/app.php';
$databaseConfig = require dirname(__DIR__) . '/config/database.php';

$container = new Container();
$router = new Router();

//dle mag salig sa conrete na classes that is why called engine.php to 
$container->bind(Engine::class, new Engine($appConfig['views_path']));
$container->bind(DatabaseDriver::class, match ($databaseConfig['driver']) {
    'mysql' => MySQLDriver::class,
    default => SQLiteDriver::class,
});
$container->bind(Connection::class, fn (Container $container): Connection => new Connection(
    driver: $container->get(DatabaseDriver::class),
    config: $databaseConfig[$databaseConfig['driver']],
));
$container->bind(ProductRepositoryInterface::class, PdoProductRepository::class);

$registerRoutes = require dirname(__DIR__) . '/routes/web.php';
$registerRoutes($router);

(new Application(container: $container, router: $router))
    ->handle(Request::capture())
    ->send();
