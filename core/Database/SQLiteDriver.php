<?php

declare(strict_types=1);

namespace Core\Database;

use Core\Contracts\DatabaseDriver;
use PDO;

final class SQLiteDriver implements DatabaseDriver
{
    public function connect(array $config): PDO
    {
        $path = (string) ($config['database'] ?? 'storage/database.sqlite');
        $directory = dirname($path);

        if (! is_dir($directory)) {
            mkdir($directory, 0775, true);
        }

        $pdo = new PDO("sqlite:{$path}");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

        return $pdo;
    }
}
