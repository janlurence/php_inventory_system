<?php
declare(strict_types=1);

return [
    'driver' => 'sqlite',
    'sqlite' => 
    [
        'database' => dirname(__DIR__) . '/storage/database.sqlite',
    ],
    'mysql' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'database' => 'mvc_inventory',
        'username' => 'root',
        'password' => '1234',
        'charset' => 'utf8mb4',
    ],
];