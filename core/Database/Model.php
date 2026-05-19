<?php

declare(strict_types=1);

namespace Core\Database;

abstract readonly class Model
{
    public function __construct(protected Connection $connection)
    {
    }

    abstract protected function table(): string;

    protected function query(): QueryBuilder
    {
        return $this->connection->table($this->table());
    }
}
