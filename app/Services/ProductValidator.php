<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ProductStatus;
use Core\Http\Request;

final class ProductValidator
{
    public function validate(Request $request): array
    {
        $data = [
            'name' => $request->string('name'),
            'sku' => strtoupper($request->string('sku')),
            'quantity' => $request->int('quantity'),
            'price' => (float) $request->string('price', '0'),
            'status' => $request->string('status', ProductStatus::InStock->value),
        ];

        $errors = [];

        if ($data['name'] === '' || strlen((string) $data['name']) < 3) {
            $errors['name'] = 'Product name must be at least 3 characters.';
        }

        if (! preg_match('/^[A-Z0-9-]{3,24}$/', (string) $data['sku'])) {
            $errors['sku'] = 'SKU must be 3-24 characters using letters, numbers, or dashes.';
        }

        if ($data['quantity'] < 0) {
            $errors['quantity'] = 'Quantity cannot be negative.';
        }

        if ($data['price'] <= 0) {
            $errors['price'] = 'Price must be greater than zero.';
        }

        if (ProductStatus::tryFrom((string) $data['status']) === null) {
            $errors['status'] = 'Choose a valid stock status.';
        }

        return [
            'valid' => $errors === [],
            'data' => $data,
            'errors' => $errors,
        ];
    }
}
