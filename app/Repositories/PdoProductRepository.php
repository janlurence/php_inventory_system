<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Product;
use Core\Database\Model;

final readonly class PdoProductRepository extends Model implements ProductRepositoryInterface
{
    protected function table(): string
    {
        return 'products';
    }

    public function all(): array
    {
        return array_map(
            callback: fn (array $row): Product => Product::fromArray($row),
            array: $this->query()->all(orderBy: 'created_at DESC, id DESC'),
        );
    }

    public function find(int $id): ?Product
    {
        $row = $this->query()->find($id);

        return $row === null ? null : Product::fromArray($row);
    }

    public function findBySku(string $sku): ?Product
    {
        $row = $this->query()->firstWhere('sku', $sku);

        return $row === null ? null : Product::fromArray($row);
    }

    public function create(array $attributes): int
    {
        return $this->query()->insert($attributes);
    }

    public function update(int $id, array $attributes): bool
    {
        return $this->query()->update($id, $attributes);
    }

    public function delete(int $id): bool
    {
        return $this->query()->delete($id);
    }
}
