<?php

declare(strict_types=1);

namespace Core\Database;

use Core\Contracts\DatabaseDriver;
use PDO;

final class Connection
{
    private ?PDO $pdo = null;

    public function __construct(
        private readonly DatabaseDriver $driver,
        private readonly array $config,
    ) {
    }

    public function pdo(): PDO
    {
        if (! $this->pdo instanceof PDO) {
            $this->pdo = $this->driver->connect($this->config);
        }

        return $this->pdo;
    }

    public function table(string $table): QueryBuilder
    {
        return new QueryBuilder(pdo: $this->pdo(), table: $table);
    }
}
