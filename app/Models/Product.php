<?php

declare(strict_types=1);

namespace App\Models;

final readonly class Product
{
    public function __construct(
        public ?int $id,
        public string $name,
        public string $sku,
        public int $quantity,
        public float $price,
        public ProductStatus $status,
        public ?string $createdAt = null,
    ) {
    }

    public static function fromArray(array $row): self
    {
        return new self(
            id: isset($row['id']) ? (int) $row['id'] : null,
            name: (string) $row['name'],
            sku: (string) $row['sku'],
            quantity: (int) $row['quantity'],
            price: (float) $row['price'],
            status: ProductStatus::from((string) $row['status']),
            createdAt: isset($row['created_at']) ? (string) $row['created_at'] : null,
        );
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'sku' => $this->sku,
            'quantity' => $this->quantity,
            'price' => $this->price,
            'status' => $this->status->value,
        ];
    }
}
