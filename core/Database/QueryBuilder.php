<?php

declare(strict_types=1);

namespace Core\Database;

use PDO;

final readonly class QueryBuilder
{
    public function __construct(
        private PDO $pdo,
        private string $table,
    ) {
    }

    public function all(string $orderBy = 'id DESC'): array
    {
        $statement = $this->pdo->query("SELECT * FROM {$this->table} ORDER BY {$orderBy}");

        return $statement->fetchAll();
    }

    public function find(int $id): ?array
    {
        $statement = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $statement->execute(['id' => $id]);
        $row = $statement->fetch();

        return $row === false ? null : $row;
    }

    public function firstWhere(string $column, mixed $value): ?array
    {
        $statement = $this->pdo->prepare("SELECT * FROM {$this->table} WHERE {$column} = :value LIMIT 1");
        $statement->execute(['value' => $value]);
        $row = $statement->fetch();

        return $row === false ? null : $row;
    }

    public function insert(array $attributes): int
    {
        $columns = array_keys($attributes);
        $placeholders = array_map(fn (string $column): string => ":{$column}", $columns);

        $statement = $this->pdo->prepare(sprintf(
            'INSERT INTO %s (%s) VALUES (%s)',
            $this->table,
            implode(', ', $columns),
            implode(', ', $placeholders),
        ));
        $statement->execute($attributes);

        return (int) $this->pdo->lastInsertId();
    }

    public function update(int $id, array $attributes): bool
    {
        $assignments = array_map(fn (string $column): string => "{$column} = :{$column}", array_keys($attributes));

        $statement = $this->pdo->prepare(sprintf(
            'UPDATE %s SET %s WHERE id = :id',
            $this->table,
            implode(', ', $assignments),
        ));

        return $statement->execute([...$attributes, 'id' => $id]);
    }

    public function delete(int $id): bool
    {
        $statement = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");

        return $statement->execute(['id' => $id]);
    }
}
