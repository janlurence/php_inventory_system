<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;

interface ProductRepositoryInterface
{
    public function all(): array;

    public function find(int $id): mixed;

    public function findBySku(string $sku): ?Product;

    public function create(array $attributes): int;

    public function update(int $id, array $attributes): bool;

    public function delete(int $id): bool;
}
